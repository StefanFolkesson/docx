---
ämne:Programmering
kategori:Kotlin
titel: 2. Grunder
---
# Grundläggande Syntax i Kotlin

Kotlin är ett modernt och uttrycksfullt programmeringsspråk som är enkelt att lära sig. Här går vi igenom de grundläggande koncepten.

## 1. Hello World
För att skriva ut text i Kotlin använder vi `println`:
```kotlin
fun main() {
    println("Hej, Kotlin!")
}
```

## 2. Variabler och Datatyper
Kotlin har både **immutabla** (`val`) och **mutabla** (`var`) variabler:

```kotlin
val name: String = "Alice"  // Konstant (kan inte ändras)
var age: Int = 25           // Variabel (kan ändras)
```
Om typen kan härledas kan den utelämnas:
```kotlin
val city = "Stockholm"
var year = 2024
```

## 3. Stränginterpolering
Du kan inkludera variabler i strängar med `$`-symbolen:
```kotlin
val name = "Bob"
println("Hej, $name!")
```

## 4. Kontrollstrukturer
### If-satser
```kotlin
val number = 10
if (number > 0) {
    println("Positivt")
} else {
    println("Negativt eller noll")
}
```

### När (switch-alternativ i Kotlin)
```kotlin
val grade = "A"
when (grade) {
    "A" -> println("Utmärkt")
    "B" -> println("Bra")
    "C" -> println("Godkänt")
    else -> println("Underkänt")
}
```

## 5. Loopar
### For-loop
```kotlin
for (i in 1..5) {
    println(i) // 1 till 5
}
```

### While-loop
```kotlin
var count = 0
while (count < 3) {
    println("Räknar: $count")
    count++
}
```

## 6. Funktioner
En enkel funktion:
```kotlin
fun add(a: Int, b: Int): Int {
    return a + b
}

val result = add(5, 10)
println("Summan är $result")
```

En kortare version:
```kotlin
fun multiply(a: Int, b: Int) = a * b
println(multiply(3, 4))
```

## 7. Listor och Mappar
### Listor
```kotlin
val fruits = listOf("Äpple", "Banan", "Körsbär")
println(fruits[0]) // Äpple
```

### Muterbar lista
```kotlin
val numbers = mutableListOf(1, 2, 3)
numbers.add(4)
println(numbers) // [1, 2, 3, 4]
```

### Mappar
```kotlin
val person = mapOf("namn" to "Anna", "ålder" to 30)
println(person["namn"]) // Anna
```

## 8. Null-säkerhet
Kotlin hanterar `null` säkert:
```kotlin
var text: String? = null
println(text?.length) // Ger null istället för fel
```

## 9. Klasser
```kotlin
class Person(val name: String, var age: Int) {
    fun introduce() {
        println("Hej, jag heter $name och är $age år gammal.")
    }
}

val person = Person("Eva", 28)
person.introduce()
```

Detta är grunderna i Kotlin! Nästa steg är att gå djupare in i objektorienterad programmering i Kotlin.