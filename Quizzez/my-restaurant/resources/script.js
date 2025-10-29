$(document).ready(function() {
    $.getJSON("resources/menu.json", function(data) {
        let menuItems = data.menu;
        let tableBody = "";

        $.each(menuItems, function(index, item) {
            tableBody += `
                <tr>
                    <td><img src="${item.image}" alt="${item.name}"></td>
                    <td><strong>${item.name}</strong></td>
                    <td>${item.description}</td>
                    <td>${item.category}</td>
                    <td>${item.cuisine}</td>
                    <td>${item.ingredients.join(", ")}</td>
                    <td><strong>${item.price}</strong></td>
                </tr>
            `;
        });

        $("#menuTable tbody").html(tableBody);
    }).fail(function() {
        $("#menuTable tbody").html("<tr><td colspan='7'>Unable to load menu data.</td></tr>");
    });
});
