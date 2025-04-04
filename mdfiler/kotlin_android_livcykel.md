---
ämne:Programmering
kategori:Kotlin
titel: 5. Livcykel
---
# En Android-apps livscykel

Varje Android-app går igenom olika tillstånd under sin livstid. Android hanterar dessa genom aktivitetslivscykeln. Det är viktigt att förstå dessa för att skapa stabila och responsiva appar.

## 1. Aktivitetens livscykel
Android hanterar en **aktivitet** (Activity) genom följande tillstånd:

1. **onCreate()** – Skapas första gången.
2. **onStart()** – Görs synlig för användaren.
3. **onResume()** – Aktiviteten är i förgrunden och interaktiv.
4. **onPause()** – En annan aktivitet får fokus (men denna är fortfarande synlig).
5. **onStop()** – Aktiviteten är inte längre synlig.
6. **onDestroy()** – Aktiviteten förstörs helt.

### Livscykeldiagram
```
    onCreate()
        ↓
    onStart()
        ↓
    onResume()  --->  [Interaktiv fas]
        ↓             ↓
    onPause()  <---  (Ny aktivitet)
        ↓
    onStop()
        ↓
    onDestroy()
```

## 2. Implementera livscykelmetoder i Kotlin

```kotlin
package com.example.lifecycleapp

import android.os.Bundle
import android.util.Log
import androidx.activity.ComponentActivity

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
        Log.d("Lifecycle", "onCreate körs")
    }

    override fun onStart() {
        super.onStart()
        Log.d("Lifecycle", "onStart körs")
    }

    override fun onResume() {
        super.onResume()
        Log.d("Lifecycle", "onResume körs")
    }

    override fun onPause() {
        super.onPause()
        Log.d("Lifecycle", "onPause körs")
    }

    override fun onStop() {
        super.onStop()
        Log.d("Lifecycle", "onStop körs")
    }

    override fun onDestroy() {
        super.onDestroy()
        Log.d("Lifecycle", "onDestroy körs")
    }
}
```

### Vad gör koden?
- Varje metod anropar `Log.d()` för att skriva ut en logg när respektive livscykelmetod körs.
- Du kan se dessa loggar i **Logcat** i Android Studio.

## 3. Hantera tillstånd med ViewModel
När en aktivitet startas om (t.ex. vid skärmrotation) kan data gå förlorad. För att spara data kan vi använda **ViewModel**.

```kotlin
import androidx.lifecycle.ViewModel

class CounterViewModel : ViewModel() {
    var count = 0
}
```

Använd ViewModel i en aktivitet:
```kotlin
import androidx.activity.viewModels
import android.os.Bundle
import android.widget.TextView
import androidx.activity.ComponentActivity
import androidx.lifecycle.ViewModel

class MainActivity : ComponentActivity() {
    private val counterViewModel: CounterViewModel by viewModels()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
        
        val textView = findViewById<TextView>(R.id.textView)
        textView.text = "Antal klick: ${counterViewModel.count}"
    }
}
```

### Fördelar med ViewModel
- Data bevaras vid skärmrotation.
- Separering av UI och datahantering.

## 4. Livscykel för en Jetpack Compose-app
Om du använder Jetpack Compose, kan du observera livscykeln via `LaunchedEffect`:

```kotlin
@Composable
fun LifecycleObserver() {
    LaunchedEffect(Unit) {
        println("Composable initieras")
    }
}
```

Detta täcker grunderna i Android-appens livscykel! Nästa steg är att optimera tillståndshantering och resurshantering i Android-appar.