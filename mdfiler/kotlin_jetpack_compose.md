---
ämne:Programmering
kategori:Kotlin
titel: 6. Jetpack Compose
---
# Grundläggande Composable-applikation i Kotlin

Jetpack Compose är Googles moderna UI-verktyg för att skapa gränssnitt i Android-appar med Kotlin. Här går vi igenom grunderna i att bygga en **Composable-applikation**.

## 1. Skapa ett nytt Compose-projekt
1. Öppna **Android Studio** och klicka på **New Project**.
2. Välj **Empty Compose Activity** och klicka **Next**.
3. Ange:
   - **Name**: MinComposableApp
   - **Package name**: com.exempel.mincomposableapp
   - **Language**: **Kotlin**
   - **Minimum API Level**: **API 23 (Android 6.0)**
4. Klicka **Finish**.

## 2. Struktur av en Compose-app
Ett Compose-baserat projekt innehåller:
- **`MainActivity.kt`** – Innehåller huvudaktiviteten och anropar Composable-funktioner.
- **`Theme.kt`** – Definierar appens färger och typografi.
- **`AndroidManifest.xml`** – Konfigurerar appen.

## 3. Första Compose-komponenten
Öppna `MainActivity.kt`, där du ser följande kod:

```kotlin
package com.exempel.mincomposableapp

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Modifier
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.exempel.mincomposableapp.ui.theme.MinComposableAppTheme

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            MinComposableAppTheme {
                MyComposableApp()
            }
        }
    }
}

@Composable
fun MyComposableApp() {
    Column(modifier = Modifier.padding(16.dp)) {
        Text(text = "Hej, Jetpack Compose!", fontSize = 24.sp)
        Spacer(modifier = Modifier.height(8.dp))
        Button(onClick = { /* Hantera klick */ }) {
            Text("Klicka mig!")
        }
    }
}

@Preview(showBackground = true)
@Composable
fun DefaultPreview() {
    MinComposableAppTheme {
        MyComposableApp()
    }
}
```

## 4. Förklaring av koden
- **`setContent {}`** – Anropar Compose UI istället för en traditionell XML-layout.
- **`@Composable`** – Markerar en funktion som en UI-komponent.
- **`Column {}`** – Layoutkomponent som staplar element vertikalt.
- **`Text()`** – Visar text.
- **`Button()`** – Skapar en knapp.
- **`Spacer()`** – Lägger till mellanrum.
- **`Preview`** – Visar UI direkt i Android Studio.

## 5. Kör appen
1. Starta en emulator eller anslut en fysisk enhet.
2. Klicka på **Run** (▶).
3. Appen startar och visar en text samt en knapp.

Detta är grunderna i Jetpack Compose! Nästa steg är att lära dig **livscykeln i en Android-app**.

