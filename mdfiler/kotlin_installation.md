---
ämne:Programmering
kategori:Kotlin
titel: 1. Installation
---
# Installation av Kotlin i Windows-miljö

## 1. Installera Java Development Kit (JDK)
Kotlin kräver en JDK för att kunna köras. Det rekommenderas att installera OpenJDK eller Oracle JDK.

### Installera OpenJDK
1. Ladda ner OpenJDK från [Adoptium](https://adoptium.net/).
2. Välj den senaste LTS-versionen av **Temurin JDK**.
3. Installera och se till att du markerar alternativet att lägga till JDK i systemets miljövariabler.

### Kontrollera installationen
Efter installation, öppna en terminal (PowerShell eller Kommandotolken) och skriv:
```sh
java -version
```
Du bör se en utskrift som visar den installerade JDK-versionen.

## 2. Installera Kotlin Compiler
Du kan installera Kotlin Compiler manuellt eller genom **SDKMAN!** eller **Kotlinc**.

### Alternativ 1: Använda SDKMAN!
1. Ladda ner och installera [SDKMAN!](https://sdkman.io/install)
2. Installera Kotlin genom att skriva:
```sh
sdk install kotlin
```

### Alternativ 2: Manuell installation
1. Ladda ner Kotlin Compiler från [Kotlin's officiella webbplats](https://github.com/JetBrains/kotlin/releases/latest).
2. Extrahera filerna och lägg till `bin`-mappen i **systemets PATH**.
3. Kontrollera installationen med:
```sh
kotlinc -version
```

## 3. Installera en IDE (Valfritt men rekommenderat)
Det är enklast att arbeta med Kotlin i en IDE som har inbyggt stöd. De vanligaste alternativen är:

- **IntelliJ IDEA** (officiellt från JetBrains)
- **Android Studio** (för Android-utveckling)
- **Visual Studio Code** med Kotlin Plugin

### Installera IntelliJ IDEA
1. Ladda ner och installera **IntelliJ IDEA Community** från [JetBrains](https://www.jetbrains.com/idea/download/).
2. Under installationen, välj att lägga till Kotlin-stöd.
3. Skapa ett nytt **Kotlin-projekt** och testa genom att skriva:
```kotlin
fun main() {
    println("Hej Kotlin!")
}
```

## 4. Köra ett Kotlin-program via terminalen
Om du vill testa Kotlin direkt från terminalen:

1. Skapa en ny fil `hello.kt` och skriv:
```kotlin
fun main() {
    println("Hej, Kotlin!")
}
```
2. Kompilera och kör programmet:
```sh
kotlinc hello.kt -include-runtime -d hello.jar
java -jar hello.jar
```

Du är nu redo att börja programmera i Kotlin!