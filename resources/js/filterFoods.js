document.getElementById('filterButton').addEventListener('click', function(event) {
    event.preventDefault();
    filterFoods();
});
function filterFoods() {
    let foodCategoryId = $('#food_category_id').val();
    let restaurantId = $('#restaurant').val();

    $.ajax({
        url: filterRoute,
        type: 'POST',
        data: {
            _token: csrfToken,
            food_category_id: foodCategoryId,
            restaurant_id: restaurantId
        },
        success: function(data) {

            $('#foods-table').html(data);
        }
    });
}


