var sideBarIsOpen = true;

 // Submenu show/hide function
 document.addEventListener('click', function(e){
    let clickedEl = e.target;

    if(clickedEl.classList.contains('showHideSubMenu')){
        let subMenu = clickedEl.closest('li').querySelector('.subMenus');
        let mainMenuIcon = clickedEl.closest('li').querySelector('.mainMenuIconArrow');

        // Close all submenus
        let subMenus = document.querySelectorAll('.subMenus');
        subMenus.forEach((sub) => {
            if(subMenu !== sub) sub.style.display = 'none';
        });

        // Call function to hide/show submenu
        showHideSubMenu(subMenu,mainMenuIcon);
    }
});

// Function - to show/hide submenu
function showHideSubMenu(subMenu,mainMenuIcon){

    // Check if there is submenu
    if(subMenu != null){
        if(subMenu.style.display === 'block') {
            subMenu.style.display = 'none';
            mainMenuIcon.classList.remove('bx-caret-down');
            mainMenuIcon.classList.add('bx-caret-left');
        } else {
            subMenu.style.display = 'block';
            mainMenuIcon.classList.remove('bx-caret-left');
            mainMenuIcon.classList.add('bx-caret-down');
        } 
    }
}



let pathArray = window.location.pathname.split('/');
let curFile = pathArray[pathArray.length - 1];

let curNav = document.querySelector('a[href="./' + curFile + '"]');
curNav.classList.add('subMenuActive');

let mainNav = curNav.closest('li.list');
mainNav.style.background = '#ffce8d';

let subMenu = mainNav.closest('.subMenus');
let mainMenuIcon = mainNav.querySelector('i.mainMenuIconArrow');
console.log(mainMenuIcon);

// Call function to hide/show submenu
showHideSubMenu(subMenu,mainMenuIcon);

 // switching section
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// view recipe
function view_recipe(id) {
    $("#viewRecipeModal").modal("show");

    let viewRecipeName = $("#recipeName-" + id).text();
    let viewCategoryName = $("#categoryName-" + id).text();
    let viewRecipeImage = $("#recipeImage-" + id).find('img').attr('src');
    let viewRecipeIngredients = $("#recipeIngredients-" + id).text();
    let viewRecipeProcedure = $("#recipeProcedure-" + id).text();

    // Update the modal content with the fetched data
    $("#viewRecipeName").text(viewRecipeName);
    $("#viewCategoryName").text(viewCategoryName);
    $("#viewRecipeImage").attr('src', viewRecipeImage);
    $("#viewRecipeIngredients").text(viewRecipeIngredients);
    $("#viewRecipeProcedure").text(viewRecipeProcedure);
}


// updating recipe 
function update_recipe(id) {
    $("#updateRecipeModal").modal("show");

    let updateRecipeID = $("#recipeID-" + id).text();
    let updateCategoryName = $("#categoryName-" + id).text();
    let updateRecipeImage = $("#recipeImage-" + id).find('img').attr('src');
    let updateRecipeName = $("#recipeName-" + id).text();
    let updateRecipeIngredients = $("#recipeIngredients-" + id).text();
    let updateRecipeProcedure = $("#recipeProcedure-" + id).text();

    $("#updateRecipeID").val(updateRecipeID);
    $("#updateRecipeCategory option").each(function() {
        let category = $(this).text();
        if (category === updateCategoryName) {
            $(this).prop("selected", true);
            return false;
        }
    });
    $("#updateRecipeName").val(updateRecipeName);
    $("#updateRecipeIngredients").val(updateRecipeIngredients);
    $("#updateRecipeProcedure").val(updateRecipeProcedure);
    $("#updateRecipeImage").html(updateRecipeImage);
}

// delete recipe
function delete_recipe(id) {

    if (confirm("Do you confirm to delete this recipe?")) {
        window.location = "database/delete-recipe.php?recipe=" + id
    }
}

// search
function performSearch() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("foodListTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        var nameColumn = tr[i].getElementsByTagName("td")[1]; // Column for Recipe Name
        var categoryColumn = tr[i].getElementsByTagName("td")[2]; // Column for Category

        if (nameColumn || categoryColumn) {
            var nameText = nameColumn.textContent || nameColumn.innerText;
            var categoryText = categoryColumn.textContent || categoryColumn.innerText;

            if (nameText.toLowerCase().indexOf(filter) > -1 || categoryText.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// Attach an event listener to the search input field
document.getElementById("searchInput").addEventListener("keyup", performSearch);
