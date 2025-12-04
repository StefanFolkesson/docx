Jag börjar med idén, sen visar jag hur det kan göras i ren JS. På slutet får du även hur man kan uttrycka “InteraktivtObjekt” som interface (med TypeScript eller som mixin i JS).

# Överblick (arv & roller)

```javascript
SpelObjekt (abstrakt bas)
 ├─ StatisktObjekt
 │   └─ Stol
 └─ RörligtObjekt
     ├─ Spelare
     └─ Fiende

InteraktivtObjekt (”kontrakt”/interface)
 ├─ Dörr  (statisk + interaktiv)
 └─ (även Spelare/Fiende kan vara interaktiva om du vill)
```

## Tänk så här

* **SpelObjekt**: gemensam grund – position, storlek, rita, kollision.
* **StatisktObjekt**: kan inte röra sig (t.ex. Stol). Ingen hastighet.
* **RörligtObjekt**: lägger till hastighet/acceleration, uppdatering per frame.
* **InteraktivtObjekt**: *ett kontrakt* som säger att objektet kan `interact(actor)`—hur det implementeras är upp till klassen (öppna dörr, plocka upp, prata…).
* **Spelare**/**Fiende**: rörliga, med extra beteenden (input/AI).
* **Stol**: statisk rekvisita; kan blockera rörelse (kollision).
* **Dörr**: statisk men interaktiv (öppna/stäng, ev. låst).

---

# Exempel i ren JavaScript (ES6)

> Not: JavaScript har inga ”riktiga” interface, men vi kan ändå **dokumentera** kontraktet och/eller använda en **mixin** (visas efter klasserna).

```javascript
// === Bas ===
class SpelObjekt {
  constructor({ x = 0, y = 0, bredd = 32, hojd = 32, solid = false, tag = "" } = {}) {
    if (new.target === SpelObjekt) {
      throw new Error("SpelObjekt är abstrakt – skapa subklasser.");
    }
    this.x = x;
    this.y = y;
    this.bredd = bredd;
    this.hojd = hojd;
    this.solid = solid;   // blockerar andra objekt vid kollision?
    this.tag = tag;       // etikett/typnamn för debug/handling
  }

  rect() {
    return { x: this.x, y: this.y, w: this.bredd, h: this.hojd };
  }

  rita(ctx) {
    // Minimal placeholder: rita en ruta
    ctx.fillRect(this.x, this.y, this.bredd, this.hojd);
  }

  krockarMed(annat) {
    const a = this.rect(), b = annat.rect();
    return a.x < b.x + b.w && a.x + a.w > b.x && a.y < b.y + b.h && a.y + a.h > b.y;
  }

  uppdatera(dt) { /* tom i basen */ }
}

// === Statisk ===
class StatisktObjekt extends SpelObjekt {
  constructor(opts = {}) {
    super({ ...opts, solid: opts.solid ?? true }); // statiska är ofta solida blockerare
  }
  // inget rörelsebeteende
}

// === Rörlig ===
class RorligtObjekt extends SpelObjekt {
  constructor(opts = {}) {
    super(opts);
    this.vx = opts.vx ?? 0;
    this.vy = opts.vy ?? 0;
    this.ax = opts.ax ?? 0;
    this.ay = opts.ay ?? 0;
    this.maxHast = opts.maxHast ?? 200;
    this.friction = opts.friction ?? 0.85;
  }

  uppdatera(dt) {
    // enkel fysik
    this.vx += this.ax * dt;
    this.vy += this.ay * dt;

    // begränsa hastighet (2D)
    const speed = Math.hypot(this.vx, this.vy);
    if (speed > this.maxHast) {
      const r = this.maxHast / speed;
      this.vx *= r; this.vy *= r;
    }

    // applicera friktion
    this.vx *= this.friction;
    this.vy *= this.friction;

    // flytta
    this.x += this.vx * dt;
    this.y += this.vy * dt;
  }
}

// === Spelare ===
class Spelare extends RorligtObjekt {
  constructor(opts = {}) {
    super({ ...opts, tag: "spelare" });
    this.hp = opts.hp ?? 100;
    this.hastighet = opts.hastighet ?? 300;
    this.inventory = [];
  }

  hanteraInput(input) {
    // input: { upp, ner, vanster, hoger, interakt }
    const acc = this.hastighet;
    this.ax = (input.hoger ? acc : 0) + (input.vanster ? -acc : 0);
    this.ay = (input.ner ? acc : 0) + (input.upp ? -acc : 0);
  }

  plocka(obj) {
    this.inventory.push(obj);
  }
}

// === Fiende ===
class Fiende extends RorligtObjekt {
  constructor(opts = {}) {
    super({ ...opts, tag: "fiende" });
    this.hp = opts.hp ?? 50;
    this.synRadie = opts.synRadie ?? 160;
    this.mal = null; // referens till Spelare
    this.patrolPoints = opts.patrolPoints ?? [];
    this._patrolIndex = 0;
  }

  uppdatera(dt) {
    // enkel AI: jaga spelaren om nära, annars patrullera
    if (this.mal && this._distTill(this.mal) < this.synRadie) {
      this._gaMot(this.mal.x, this.mal.y, dt);
    } else if (this.patrolPoints.length) {
      const p = this.patrolPoints[this._patrolIndex];
      if (this._gaMot(p.x, p.y, dt) < 5) {
        this._patrolIndex = (this._patrolIndex + 1) % this.patrolPoints.length;
      }
    }
    super.uppdatera(dt);
  }

  _gaMot(tx, ty, dt) {
    const dx = tx - this.x, dy = ty - this.y;
    const d = Math.hypot(dx, dy) || 1;
    this.ax = (dx / d) * 200;
    this.ay = (dy / d) * 200;
    return d;
  }

  _distTill(o) { return Math.hypot(o.x - this.x, o.y - this.y); }
}

// === Stol (statisk rekvisita) ===
class Stol extends StatisktObjekt {
  constructor(opts = {}) {
    super({ ...opts, tag: "stol", bredd: opts.bredd ?? 24, hojd: opts.hojd ?? 24 });
  }
}

// === Dörr (statisk + interaktiv) ===
class Dorr extends StatisktObjekt {
  constructor(opts = {}) {
    super({ ...opts, tag: "dorr", solid: true });
    this.oppnad = opts.oppnad ?? false;
    this.lasd = opts.lasd ?? false;
    this.nyckelTag = opts.nyckelTag ?? null; // om låst: vilken nyckel krävs?
    this._uppdateraSolid();
  }

  _uppdateraSolid() {
    // öppen dörr blockerar inte
    this.solid = !this.oppnad;
  }

  interact(actor) {
    // "InteraktivtObjekt"-kontrakt: aktören försöker interagera
    if (this.lasd) {
      // om låst, kolla inventory
      if (actor.inventory?.some(i => i.tag === this.nyckelTag)) {
        this.lasd = false;
      } else {
        return { ok: false, msg: "Dörren är låst." };
      }
    }
    this.oppnad = !this.oppnad;
    this._uppdateraSolid();
    return { ok: true, msg: this.oppnad ? "Du öppnar dörren." : "Du stänger dörren." };
  }
}
```

### Attribut & metoder (korta exempel att peka på i klassrummet)

* **SpelObjekt**

  * Attribut: `x, y, bredd, hojd, solid, tag`
  * Metoder: `rita(ctx)`, `rect()`, `krockarMed(annat)`, `uppdatera(dt)`
* **RörligtObjekt**

  * Attribut: `vx, vy, ax, ay, maxHast, friction`
  * Metoder: `uppdatera(dt)` (fysik + förflyttning)
* **StatisktObjekt**: ärver, inga extra (ofta bara `solid = true`)
* **Spelare**

  * Attribut: `hp, hastighet, inventory`
  * Metoder: `hanteraInput(input)`, `plocka(obj)`
* **Fiende**

  * Attribut: `hp, synRadie, mal, patrolPoints`
  * Metoder: `uppdatera(dt)` (AI), `_gaMot`, `_distTill`
* **Stol**

  * Attribut: ev. specialmått, `solid: true`
* **Dörr**

  * Attribut: `oppnad, lasd, nyckelTag, solid`
  * Metoder: `interact(actor)` (öppna/stäng/låslogik)

---

## InteraktivtObjekt som ”interface”

### 1) TypeScript (pedagogiskt rent)

Om gruppen tål lite TypeScript kan du använda ett riktigt interface:

```typescript
interface InteraktivtObjekt {
  interact(actor: SpelObjekt): { ok: boolean; msg?: string };
}

// Dörr implementerar interfacet:
class Dorr extends StatisktObjekt implements InteraktivtObjekt {
  // ...som ovan...
  interact(actor: SpelObjekt) { /* ... */ }
}
```

### 2) JavaScript mixin (”duck typing”)

I ren JS kan vi dokumentera kontraktet och validera i körning:

```javascript
const InteraktivtMixin = Base => class extends Base {
  interact(actor) {
    throw new Error("interact(actor) måste implementeras av interaktiva objekt.");
  }
};

// Exempel: gör Dörr ”interaktiv” genom att ärva mixin
class InteraktivDorr extends InteraktivtMixin(Dorr) {
  interact(actor) {
    return super.interact(actor); // återanvänd Dorrs implementering
  }
}
```

I praktiken räcker det ofta att **dokumentera** att objekt har en `interact(actor)`-metod och låta koden kalla den om den finns (”duck typing”).

---

## Minimal spel-loop (för att demonstrera samspel)

```javascript
const ctx = canvas.getContext("2d");
const spelare = new Spelare({ x: 50, y: 50 });
const fiende  = new Fiende({ x: 200, y: 200, patrolPoints:[{x:200,y:200},{x:300,y:220}] });
fiende.mal = spelare;

const stol  = new Stol({ x: 120, y: 120 });
const dorr  = new Dorr({ x: 300, y: 100, lasd: true, nyckelTag: "gul-nyckel" });

// Ge spelaren nyckeln:
spelare.plocka({ tag: "gul-nyckel" });

let senast = performance.now();
function loop(nu) {
  const dt = (nu - senast) / 1000; senast = nu;

  // Input -> spelare
  spelare.hanteraInput(lasInput());

  // Uppdatera
  spelare.uppdatera(dt);
  fiende.uppdatera(dt);

  // Enkel interaktion: om spelare står vid dörren och trycker E
  if (input.e && spelare.krockarMed(dorr)) {
    const res = dorr.interact(spelare);
    if (!res.ok) console.log(res.msg);
  }

  // Rita
  ctx.clearRect(0,0,canvas.width,canvas.height);
  [stol, dorr, fiende, spelare].forEach(o => o.rita(ctx));

  requestAnimationFrame(loop);
}
requestAnimationFrame(loop);
```

---

## Pedagogiska tips i klassrummet

* **Arv först, interface sen**: låt eleverna se nyttan av gemensam bas (position/kollision) innan ni lägger till ”kontrakt”.
* **Små inkrementella steg**: börja med `SpelObjekt → Statiskt/Stol`. Lägg sedan till `Rörligt → Spelare`, sist `Fiende` och `Dörr`.
* **Övningar**:

  1. Lägg till `TaSkada(dmg)` på **Spelare/Fiende**.
  2. Gör **Stol** icke-solid och visa skillnaden (man kan gå igenom).
  3. Lägg till **tryckplatta** som är statisk men interaktiv (aktiverar något).
  4. Gör **Spelare** också interaktiv (kan prata med NPC via `interact`).