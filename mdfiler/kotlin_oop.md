---
ämne:Programmering
kategori:Kotlin
titel: 3. OOP
---
# Objektorienterad Programmering i Kotlin

Kotlin är ett objektorienterat språk med stöd för klasser, arv, interfaces och mer. Här går vi igenom grunderna i OOP i Kotlin.

## 1. Klasser och Objekt
En klass definieras med `class`-nyckelordet:
```kotlin
class Person(val name: String, var age: Int) {
    fun introduce() {
        println("Hej, jag heter $name och är $age år gammal.")
    }
}

val person = Person("Anna", 25)
person.introduce()
```

## 2. Konstruktorer
Kotlin har **primära** och **sekundära** konstruktorer.

### Primär konstruktor
```kotlin
class Car(val brand: String, val model: String) {
    fun showInfo() {
        println("Bilen är en $brand $model")
    }
}
```

### Sekundär konstruktor
```kotlin
class Student {
    var name: String
    var age: Int
    
    constructor(name: String, age: Int) {
        this.name = name
        this.age = age
    }
}
```

## 3. Arv
Kotlin använder `open` för att möjliggöra arv (klasser är `final` som standard).

```kotlin
open class Animal(val name: String) {
    open fun makeSound() {
        println("Djur gör ett ljud")
    }
}

class Dog(name: String) : Animal(name) {
    override fun makeSound() {
        println("Voff voff!")
    }
}

val myDog = Dog("Buddy")
myDog.makeSound() // Voff voff!
```

## 4. Interfaces
Ett interface definierar beteenden som klasser kan implementera.

```kotlin
interface Movable {
    fun move()
}

class Car : Movable {
    override fun move() {
        println("Bilen kör framåt")
    }
}

val car = Car()
car.move()
```

## 5. Data-klasser
Data-klasser används för att lagra data och kommer med `toString`, `hashCode`, `equals` och `copy`.

```kotlin
data class User(val name: String, val age: Int)

val user1 = User("Alice", 30)
val user2 = user1.copy(age = 31)
println(user1) // User(name=Alice, age=30)
println(user2) // User(name=Alice, age=31)
```

## 6. Singleton (Object Keyword)
Om du behöver en klass med bara en instans kan du använda `object`.

```kotlin
object Logger {
    fun log(message: String) {
        println("LOG: $message")
    }
}

Logger.log("Systemet startas")
```

## 7. Kompanjonsobjekt
`companion object` används för att definiera statiska medlemmar i en klass.

```kotlin
class MathUtils {
    companion object {
        fun add(a: Int, b: Int) = a + b
    }
}

val sum = MathUtils.add(5, 10)
println("Summan är $sum")
```

Detta täcker grunderna i OOP i Kotlin. Nästa steg är att implementera dessa koncept i Android-utveckling!

