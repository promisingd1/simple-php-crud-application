document.addEventListener('DOMContentLoaded', function () {
    const list = document.querySelectorAll('.delete');
    console.log(list)

    for (let i = 0; i < list.length ; i++ ) {
        list[i].addEventListener('click', function (e){
            if (!confirm("Are you sure to delete?")) {
                e.preventDefault();
            }
        })
    }
})