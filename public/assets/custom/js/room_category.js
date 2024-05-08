$(document).ready(function() {
    getAllroomCategories();
});

function getAllroomCategories(){
    var i = 1;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var columns = [
        { "data": "0" },
        { "data": "category" },
        { "data": "size" },
        { "data": "id",
          "render": function ( data, type, full, meta ) {
            var people = full.people_adult+" Adults ";
            if(full.people_child == 1){
                people += "1 Child";
            }
            else{
                people += full.people_child+" Children";
            }
            return people;
          }
        },
        { "data": "bed" },
        { "data": "price",
          "render": function ( data, type, full, meta ) {
            return 'BDT '+data;
          }
        },
        { "data": "check_in" },
        { "data": "check_out" }
    ];

    if(editaction || viewaction || deleteaction){
        columns.push({
            "data": "id",
            "render": function ( data, type, full, meta ) {
                var buttons = "";
                if(editaction){
                    buttons += "<a href=\"room-category/edit/"+data+"\"><button class=\"btn btn-primary waves-effect waves-light\"><i class=\"fa fa-edit\"></i>&nbsp Edit</button></a>";
                }
                if(viewaction){
                    buttons += "&nbsp<a href=\"room-category/view/"+data+"\"><button class=\"btn btn-success waves-effect waves-light\"><i class=\"fa fa-edit\"></i>&nbsp View</button></a>"
                }
                if(deleteaction){
                    buttons += "&nbsp<button class=\"btn btn-danger waves-effect waves-light\" onclick=\"deleteRoomCategory("+data+")\"><i class=\"fa fa-trash\"></i>&nbsp Delete</button>"
                }
                return buttons;
            }
        });
    }


    var table= $('#roomCategoriesTable').DataTable( {
        "processing": true,
        "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
        "pageLength": 10,
        "serverSide": true,
        "destroy" :true,
        "ajax": {
            "url": './room-category',
            "type": 'POST',
            // "data": function ( d ) {
            //     d.current_semester = $('#current_semester').val();
            // },
        },
        "columns": columns
    });
}

function deleteRoomCategory(id){
    var txt;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Are you sure want to delete ?',
        // text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: 'users/delete/'+id,
                data: {
                  id : id
                },
                dataType: 'json',
            })
            .done(function (data) {
                if(data){
                    Swal.fire(
                      'Successfully Deleted',
                      '',
                      'success'
                    );
                    getAllUsers();
                }
                else{
                    Swal.fire(
                      'Sorry! User could not be deleted',
                      '',
                      'error'
                    );
                }
            });
        }
    })
}