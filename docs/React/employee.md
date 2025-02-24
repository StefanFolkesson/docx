Självklart! Här är en enkel React-app som implementerar ett sökfält för att filtrera en lista på anställda med hjälp av **functional components** och **state hooks**.

---

### Steg-för-steg-guide

#### 1. Skapa projekt
Följ instruktionerna ovan för att skapa ett React-projekt om du inte redan har ett.

---

#### 2. Strukturera projektet
Skapa en mappstruktur:
```
src/
├── components/
│   ├── EmployeeList.js
│   ├── SearchBar.js
├── App.js
```

---

#### 3. Skapa komponenterna

##### **`EmployeeList.js`**
Denna komponent tar emot en lista med anställda som en prop och visar den filtrerade listan.

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

##### **`SearchBar.js`**
En komponent med ett sökfält som hanterar söksträngen.

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

##### **`App.js`**
Huvudkomponenten där allt hänger ihop.

```jsx
import React, { useState } from 'react';
import EmployeeList from './components/EmployeeList';
import SearchBar from './components/SearchBar';

function App() {
  // Lista med anställda
  const [employees] = useState([
    { id: 1, name: 'Alice' },
    { id: 2, name: 'Bob' },
    { id: 3, name: 'Charlie' },
    { id: 4, name: 'Diana' },
  ]);

  // Söksträngens state
  const [searchTerm, setSearchTerm] = useState('');

  // Filtrera anställda baserat på söksträngen
  const filteredEmployees = employees.filter((employee) =>
    employee.name.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div style={{ padding: '20px', fontFamily: 'Arial' }}>
      <h1>Employee Search</h1>
      {/* Sökfält */}
      <SearchBar searchTerm={searchTerm} onSearch={setSearchTerm} />

      {/* Filtrerad lista */}
      <EmployeeList employees={filteredEmployees} />
    </div>
  );
}

export default App;
```

---

### Förklara koden

1. **State Management**:
   - `employees` är en statisk lista med anställda.
   - `searchTerm` används för att lagra söksträngen.

2. **Filtrering**:
   - Metoden `filter` används på `employees` för att filtrera listan baserat på söksträngen.

3. **Komponentstruktur**:
   - `SearchBar` ansvarar för att hantera användarens input.
   - `EmployeeList` ansvarar för att visa en filtrerad lista.

---

### 4. Starta applikationen
Kör följande i terminalen:
```bash
npm start
```

---

### Slutresultat
1. Ett sökfält visas överst.
2. När du skriver in text i sökfältet filtreras listan med anställda i realtid.
3. Om ingen matchning finns visas texten "No employees found".

Du kan enkelt utöka detta exempel genom att lägga till fler detaljer om de anställda eller implementera avancerade funktioner som sortering. 🚀