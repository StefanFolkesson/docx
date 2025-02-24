För att skapa en React-app som skickar en GET-förfrågan till en extern PHP-API för att hämta och presentera data (t.ex. en lista på anställda), följer här en steg-för-steg-guide.

---

### Steg 1: **Starta en React-app**
Följ instruktionerna ovan för att skapa en ny React-app om du inte redan har en.

---

### Steg 2: **Installera Axios**
Vi använder Axios för att göra HTTP-förfrågningar:
```bash
npm install axios
```

---

### Steg 3: **Strukturera projektet**
Skapa följande mappstruktur:
```
src/
├── components/
│   ├── EmployeeList.js
│   ├── SearchBar.js
├── App.js
```

---

### Steg 4: **Implementera komponenterna**

#### **EmployeeList.js**
Denna komponent visar listan på anställda som hämtas från API:et.
```jsx
import React from 'react';

function EmployeeList({ employees }) {
  return (
    <ul>
      {employees.length > 0 ? (
        employees.map((employee) => (
          <li key={employee.id}>{employee.name}</li>
        ))
      ) : (
        <p>No employees found</p>
      )}
    </ul>
  );
}

export default EmployeeList;
```

---

#### **SearchBar.js**
Denna komponent innehåller ett textfält där användaren kan skriva in en söksträng.
```jsx
import React from 'react';

function SearchBar({ searchTerm, onSearch }) {
  return (
    <input
      type="text"
      placeholder="Search employees..."
      value={searchTerm}
      onChange={(e) => onSearch(e.target.value)}
    />
  );
}

export default SearchBar;
```

---

#### **App.js**
Här kombineras komponenterna, och API-förfrågan görs.

```jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import EmployeeList from './components/EmployeeList';
import SearchBar from './components/SearchBar';

function App() {
  const [searchTerm, setSearchTerm] = useState('');
  const [employees, setEmployees] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  // Hämta data från API baserat på söksträng
  useEffect(() => {
    if (searchTerm.trim() === '') {
      setEmployees([]);
      return;
    }

    const fetchEmployees = async () => {
      setLoading(true);
      setError('');
      try {
        const response = await axios.get(`https://your-api-url.com/api.php?search=${searchTerm}`);
        setEmployees(response.data); // Anta att API:et returnerar en array
      } catch (err) {
        setError('Failed to fetch employees');
      } finally {
        setLoading(false);
      }
    };

    fetchEmployees();
  }, [searchTerm]);

  return (
    <div style={{ padding: '20px', fontFamily: 'Arial' }}>
      <h1>Employee Search</h1>
      {/* Sökfält */}
      <SearchBar searchTerm={searchTerm} onSearch={setSearchTerm} />

      {/* Laddningsindikator */}
      {loading && <p>Loading...</p>}

      {/* Felmeddelande */}
      {error && <p style={{ color: 'red' }}>{error}</p>}

      {/* Filtrerad lista */}
      <EmployeeList employees={employees} />
    </div>
  );
}

export default App;
```

---

### Steg 5: **Testa applikationen**
1. Byt ut `https://your-api-url.com/api.php` med din faktiska API-adress.
2. Starta din React-app:
   ```bash
   npm start
   ```

---

### Hur det fungerar
1. **Textfält för sökning**:
   - När du skriver in text i textfältet uppdateras `searchTerm`-state.

2. **API-förfrågan**:
   - När `searchTerm` ändras körs `useEffect`, vilket skickar en GET-förfrågan till API:et med söksträngen som query-parameter.

3. **Presentera resultat**:
   - Svaret från API:et används för att uppdatera `employees`-state, som sedan skickas som en prop till `EmployeeList`-komponenten.

4. **Felhantering**:
   - Om API:et inte svarar eller ett fel inträffar visas ett felmeddelande.

---

### Exempel på API
Ett PHP-skript som returnerar JSON kan se ut så här:
```php
<?php
header('Content-Type: application/json');

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Mockad data
$employees = [
    ['id' => 1, 'name' => 'Alice'],
    ['id' => 2, 'name' => 'Bob'],
    ['id' => 3, 'name' => 'Charlie'],
    ['id' => 4, 'name' => 'Diana'],
];

// Filtrera baserat på söksträng
$result = array_filter($employees, function ($employee) use ($search) {
    return stripos($employee['name'], $search) !== false;
});

echo json_encode(array_values($result));
```

---

Nu har du en fullt fungerande React-app som skickar data till en PHP-API och visar resultatet. 🚀