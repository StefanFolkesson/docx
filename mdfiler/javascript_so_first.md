
* **SpelObjekt**: abstrakt + inkapslat (privata fält för position & bildtyp).
* **StatisktObjekt**: egen typ ”statisk”.
* **RörligtObjekt**: riktning + acceleration (enkelt, ”lagom fejk”).
* **Spelare**: styrs via **tangentbord (pilar)** med en Controller.
* **Fiende**: vänder sig mot spelaren.
* **Alla objekt i en lista**; först typ-specifik effekt, sen generisk `uppdatera()`.

```js
// ===== Abstrakt bas =====
class SpelObjekt {
  #x; #y; #bild;
  constructor({ x=0, y=0, bild="okand" } = {}) {
    if (new.target === SpelObjekt) throw new Error("SpelObjekt är abstrakt.");
    this.#x = x; this.#y = y; this.#bild = bild;
    this.type = "bas";
  }
  get x(){ return this.#x }  get y(){ return this.#y }  get bild(){ return this.#bild }
  // "skyddat" via konvention: används av subklasser
  _setPos(x,y){ this.#x = x; this.#y = y; }
  _moveBy(dx,dy){ this.#x += dx; this.#y += dy; }

  uppdatera(dt, world){}      // generisk hook
  rita(ctx){}                 // generisk hook (ex: drawImage)
}

// ===== Statisk =====
class StatisktObjekt extends SpelObjekt {
  constructor(opts={}) {
    super({ ...opts, bild: opts.bild ?? "statisk" });
    this.type = "statisk";
  }
  // ingen rörelse
}

// ===== Rörlig =====
class RorligtObjekt extends SpelObjekt {
  #riktning; #acc; #hast; #max;
  constructor(opts={}) {
    super(opts);
    this.#riktning = opts.riktning ?? 0;   // radianer
    this.#acc = opts.acceleration ?? 0;    // skalär
    this.#hast = opts.hastighet ?? 0;
    this.#max = opts.maxHast ?? 200;
  }
  get riktning(){ return this.#riktning }
  setRiktning(v){ this.#riktning = v }
  setAcceleration(a){ this.#acc = a }

  uppdatera(dt, world){
    this.#hast += this.#acc * dt;
    if (this.#hast < 0) this.#hast = 0;
    if (this.#hast > this.#max) this.#hast = this.#max;
    this._moveBy(Math.cos(this.#riktning) * this.#hast * dt,
                 Math.sin(this.#riktning) * this.#hast * dt);
  }
}

// ===== Spelare (med tangentbords-kontroller) =====
class Spelare extends RorligtObjekt {
  constructor(opts={}) {
    super({ ...opts, bild: opts.bild ?? "spelare" });
    this.type = "spelare";
    this.controller = opts.controller ?? new PilController();
  }
  uppdatera(dt, world){
    this.controller.styr(this, world, dt);   // sätter riktning/acc
    super.uppdatera(dt, world);
  }
}

// Enkel controller: pilar ← → roterar, ↑ gasar
class PilController {
  #keys = { ArrowLeft:false, ArrowRight:false, ArrowUp:false };
  constructor() {
    addEventListener("keydown", e => { if (e.code in this.#keys) this.#keys[e.code]=true; });
    addEventListener("keyup",   e => { if (e.code in this.#keys) this.#keys[e.code]=false; });
  }
  styr(obj, world, dt){
    const TURN = 3.0, ACC = 120;
    let r = obj.riktning;
    if (this.#keys.ArrowLeft)  r -= TURN*dt;
    if (this.#keys.ArrowRight) r += TURN*dt;
    obj.setRiktning(r);
    obj.setAcceleration(this.#keys.ArrowUp ? ACC : 0);
  }
}

// ===== Fiende (rör sig mot spelaren) =====
class Fiende extends RorligtObjekt {
  constructor(opts={}) {
    super({ ...opts, bild: opts.bild ?? "fiende" });
    this.type = "fiende";
    this.jaktAcc = opts.jaktAcc ?? 100;
  }
  // typ-specifik effekt: sikta mot spelaren
  siktaMot(spelare){
    const dx = spelare.x - this.x, dy = spelare.y - this.y;
    this.setRiktning(Math.atan2(dy, dx));
    this.setAcceleration(this.jaktAcc);
  }
}

// ===== Exempel: specifika statiska objekt =====
class Stol extends StatisktObjekt {
  constructor(opts={}) { super({ ...opts, bild: "stol" }); }
}

// ===== Värld: alla objekt i EN lista =====
const world = { objekt: [], spelare: null };

// Skapa några objekt
world.spelare = new Spelare({ x: 100, y: 100 });
world.objekt.push(world.spelare);
world.objekt.push(new Fiende({ x: 380, y: 220 }));
world.objekt.push(new Fiende({ x: 260, y: 320 }));
world.objekt.push(new Stol({ x: 200, y: 200 }));   // statiskt exempel

// Central hantering: 1) typ-specifika effekter -> 2) generisk uppdatera
function uppdateraVarld(dt){
  for (const o of world.objekt){
    if (o.type === "fiende" && world.spelare) o.siktaMot(world.spelare);
    // "spelare" styrs redan via controller i sin uppdatera()
    // "statisk" gör inget typ-specifikt här
  }
  for (const o of world.objekt) o.uppdatera(dt, world);
}

// Minimal “tick-loop” för demo (ingen grafik, bara struktur)
let t=0; const step=0.016;
const timer = setInterval(()=>{
  t += step; if (t>1.0) clearInterval(timer); // kör ~1s
  uppdateraVarld(step);
  // console.log(world.spelare.x, world.spelare.y); // valfritt för att se rörelse
}, step*1000);
```

### Varför detta funkar bra pedagogiskt

* **Abstrakt + inkapslat**: basen kan inte instansieras; position & bild är privata.
* **Tydliga roller**: statiskt vs rörligt; controller separerar **input** från **objektets data**.
* **En lista, två pass**: först typberoende logik, sen generisk `uppdatera()` för alla.
* **Enkelt att bygga vidare**: lägg till `Dörr` (statisk), `Skott` (rörligt), kollisioner etc. utan att ändra kärn-strukturen.

