document.addEventListener("DOMContentLoaded", function () {
    fetch("get_suggestions.php")
        .then(response => response.json())
        .then(data => {
            setupAutocomplete(document.querySelector("input[name='yamlsubject']"), data.subjects);
            setupAutocomplete(document.querySelector("input[name='yamlkat']"), data.categories);
        });

    function setupAutocomplete(input, suggestions) {
        let list = document.createElement("ul");
        list.className = "autocomplete-list";
        input.parentNode.appendChild(list);

        input.addEventListener("input", function () {
            let value = this.value.toLowerCase();
            list.innerHTML = "";
            if (value.length > 0) {
                suggestions
                    .filter(item => item.toLowerCase().includes(value))
                    .forEach(suggestion => {
                        let item = document.createElement("li");
                        item.textContent = suggestion;
                        item.addEventListener("click", () => {
                            input.value = suggestion;
                            list.innerHTML = "";
                        });
                        list.appendChild(item);
                    });
            }
        });

        document.addEventListener("click", function (e) {
            if (!input.contains(e.target) && !list.contains(e.target)) {
                list.innerHTML = "";
            }
        });
    }
});

