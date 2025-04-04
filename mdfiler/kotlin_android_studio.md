---
ämne:Programmering
kategori:Kotlin
titel: 4. Android Studio
---
# Kom igång med Android Studio och Kotlin

Android Studio är den officiella IDE:n för Android-utveckling och har fullt stöd för Kotlin. Här går vi igenom hur du installerar och skapar ditt första Kotlin-baserade Android-projekt.

## 1. Installera Android Studio

1. Ladda ner Android Studio från [den officiella webbplatsen](https://developer.android.com/studio).
2. Kör installationsfilen och följ instruktionerna.
3. Under installationen, se till att **Android SDK**, **Android Virtual Device (AVD)** och **Android Emulator** är markerade.

### Kontrollera installationen
Öppna terminalen i Android Studio och skriv:
```sh
flutter doctor
```
Om du ser att allt är korrekt installerat, är du redo att börja.

## 2. Skapa ett nytt Android-projekt

1. Öppna Android Studio och klicka på **New Project**.
2. Välj **Empty Activity** och klicka **Next**.
3. Ange följande:
   - **Name**: MittFörstaApp
   - **Package name**: com.exempel.mittförstaapp
   - **Save location**: Välj en mapp där projektet ska sparas.
   - **Language**: **Kotlin**
   - **Minimum API Level**: Rekommenderat är API 23 (Android 6.0)
4. Klicka **Finish** och vänta tills projektet skapas.

## 3. Struktur av ett Android-projekt
Ett typiskt Kotlin-baserat Android-projekt har följande viktiga filer:

- **`MainActivity.kt`** – Huvudaktiviteten (startpunkten för appen).
- **`AndroidManifest.xml`** – Konfigurationsfil för appen.
- **`res/layout/activity_main.xml`** – UI-layout för huvudaktiviteten.
- **`gradle.build`** – Byggkonfigurationer.

## 4. Första Kotlin-koden i Android Studio

Öppna `MainActivity.kt` och du bör se följande kod:
```kotlin
package com.exempel.mittförstaapp

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
    }
}
```
Denna kod definierar **huvudaktiviteten** och länkar den till en layoutfil (`activity_main.xml`).

## 5. Ändra UI i XML

Gå till `res/layout/activity_main.xml` och ändra `TextView` till:
```xml
<TextView
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:text="Hej, Kotlin!"
    android:textSize="24sp"
    android:layout_centerInParent="true" />
```

## 6. Testa appen
För att köra appen:
1. Anslut en fysisk Android-enhet eller starta en emulator via **AVD Manager**.
2. Klicka på den gröna **Run**-knappen (▶) i Android Studio.
3. Appen bör visas med texten **Hej, Kotlin!**.

Nu har du skapat din första Android-app i Kotlin! Nästa steg är att lära dig om **Jetpack Compose** och skapa en Composable-applikation.

