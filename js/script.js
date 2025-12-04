function showNotification(message, type) {
  let notify = document.getElementById("notify");
  notify.className = "notify " + type;
  console.log(message);
  notify.innerText = message;
  notify.style.display = "block";

  // Visa notisen gradvis
  setTimeout(() => {
    notify.style.opacity = "1";
  }, 100);

  // Dölj efter 3 sekunder
  setTimeout(() => {
    notify.style.opacity = "0";
    setTimeout(() => {
      notify.style.display = "none";
    }, 500);
  }, 3000);
}
function confirmDelete(filename) {
  if (confirm("Är du säker på att du vill ta bort " + filename + "?")) {
    fetch("delete.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "file=" + encodeURIComponent(filename),
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "success") {
          showNotification("Filen har raderats!", "success");
          setTimeout(() => location.reload(), 1000); // Uppdatera sidan efter 1 sekund
        } else {
          showNotification(data, "error");
        }
      })
      .catch((error) => showNotification("Ett fel uppstod!", "error"));
  }
}
function toggleCategory(id) {
  var element = document.getElementById(id);
  if (element.style.display === "none" || element.style.display === "") {
    element.style.display = "block";
  } else {
    element.style.display = "none";
  }
}

function copyToClipboard(text) {
  navigator.clipboard
    .writeText(text)
    .then(() => {
      showNotification("Copied to clipboard!", "success");
    })
    .catch((err) => {
      showNotification("Failed to copy!", "error");
    });
}

function insertAtCursor(input, text) {
  console.log("input");
  inputt = document.querySelector("textarea[name='markdown']");
  if (inputt.selectionStart || inputt.selectionStart === 0) {
    let startPos = inputt.selectionStart;
    let endPos = inputt.selectionEnd;
    inputt.value =
      inputt.value.substring(0, startPos) +
      text +
      inputt.value.substring(endPos, inputt.value.length);
  } else {
    inputt.value += text;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const subHeaders = document.querySelectorAll(".sub");
  subHeaders.forEach((header) => {
    header.style.cursor = "pointer";
    let nextElem = header.nextElementSibling;
    let shouldExpand = false;
    const groupItems = [];

    // Samla in alla li-element under den aktuella .sub och kolla om någon är aktiv.
    while (nextElem && nextElem.tagName.toLowerCase() === "li") {
      groupItems.push(nextElem);
      if (nextElem.querySelector("a.active")) {
        shouldExpand = true;
      }
      nextElem = nextElem.nextElementSibling;
    }

    // Om gruppen inte ska vara expanderad, dölj alla li-element. Annars, visa dem.
    groupItems.forEach((li) => {
      li.style.display = shouldExpand ? "list-item" : "none";
    });

    // Om någon li hade en aktiv länk, sätt pilen i expanderat läge.
    if (shouldExpand) {
      header.classList.add("expanded");
    }

    // Klickhändelse för att toggla gruppens visning
    header.addEventListener("click", function () {
      header.classList.toggle("expanded");
      groupItems.forEach((li) => {
        li.style.display = li.style.display === "none" ? "list-item" : "none";
      });
    });
  });
});
document.addEventListener(
  "keydown",
  function (e) {
    // Kolla om Ctrl (eller Cmd på Mac) och "s" trycks ned
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === "s") {
      e.preventDefault(); // Förhindrar webbläsarens standardfunktion (spara sidan)
      e.stopPropagation(); // Förhindra att eventet fortsätter spridas
      // Hitta knappen med id "myButton" och simulera ett klick
      document.getElementById("save_button").click();
    }
  },
  true
);
function goTo(file) {
  // Skapa den relativa sökvägen med "view.php" istället för "edit.php"
  const relativePath = "view.php?file=" + file;

  // Skapar ett URL-objekt baserat på den aktuella adressen (med origin och underkataloger)
  const url = new URL(relativePath, window.location.href);

  // Uppdaterar webbläsarens adressfält utan att ladda om sidan
  window.location.href = url; // Ladda den nya sidan
}

function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    {
      pageLanguage: "sv", // Ursprungspråket
      autoDisplay: false, // Visa inte widgeten automatiskt
    },
    "google_translate_element"
  );
}

// Funktion för att byta språk via widgetens select-element
function changeLanguage(lang) {
  document.getElementById("lan_lbl").innerText =
    lang === "en" ? "English" : "Svenska"; // Ändra etikett beroende på språk
  // Hitta Google Translates språkval (select element med klassen goog-te-combo)
  var selectField = document.querySelector(".goog-te-combo");
  if (selectField) {
    selectField.value = lang; // Ändra värdet (ex. 'en' för engelska eller 'sv' för svenska)
    // Skapa och trigga ett "change"-event för att tvinga fram översättningen
    selectField.dispatchEvent(new Event("change"));
  } else {
    // Om widgeten inte är inläst än, försök igen efter en kort fördröjning
    setTimeout(function () {
      changeLanguage(lang);
    }, 250);
  }
}

// Lyssna på ändringar i checkboxen
document
  .getElementById("translateCheckbox")
  .addEventListener("change", function () {
    if (this.checked) {
      changeLanguage("en"); // Översätt till engelska
    } else {
      changeLanguage("sv"); // Återställ till originalspråket
    }
  });

  const inputField = document.getElementById('fileName');

    if (inputField) {
      inputField.addEventListener('input', function() {
        // Ersätt alla tecken som inte är bokstäver, siffror eller understreck
        this.value = this.value.replace(/[^A-Za-z0-9_]/g, '');
      });
    }

// Mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
  // Use matchMedia for responsive detection
  const mobileMediaQuery = window.matchMedia('(max-width: 768px)');
  
  function handleMobileMenu() {
    const menuItems = document.querySelectorAll('.menu > ul > li');
    
    if (mobileMediaQuery.matches) {
      // Apply mobile menu behavior
      menuItems.forEach(function(item) {
        // Remove any existing listeners by cloning
        const newItem = item.cloneNode(true);
        item.parentNode.replaceChild(newItem, item);
        
        newItem.addEventListener('click', function(e) {
          // Toggle active class
          newItem.classList.toggle('active');
          e.stopPropagation();
        });
        
        // Handle sub-dropdown items
        const dropdownItems = newItem.querySelectorAll('.dropdown > li');
        dropdownItems.forEach(function(dropdownItem) {
          dropdownItem.addEventListener('click', function(e) {
            dropdownItem.classList.toggle('active');
            e.stopPropagation();
          });
        });
      });
    } else {
      // Remove mobile behavior on desktop (use CSS hover)
      menuItems.forEach(function(item) {
        item.classList.remove('active');
        const dropdownItems = item.querySelectorAll('.dropdown > li');
        dropdownItems.forEach(function(dropdownItem) {
          dropdownItem.classList.remove('active');
        });
      });
    }
  }
  
  // Initial setup
  handleMobileMenu();
  
  // Re-apply on orientation/resize changes
  mobileMediaQuery.addListener(handleMobileMenu);
});
