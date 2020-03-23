$(document).ready(function(){
    $(".search-button").on('click',function(){
        const val = $(".search-input").val();
        $.ajax({
            type: "GET",
            q: val,
            url: '/api/autoservice/search/?name='+val,
            success: function( data ) {
                $('#for-replace').replaceWith(data);
            }
        });
    });

    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var modal = $(this);
        modal.find('#id').val(button.data('id'));
        modal.find('#name').val(button.data('name') );
        modal.find('#address').val(button.data('address'));
        modal.find('#tel').val(button.data('tel'));
        modal.find('#email').val(button.data('email'));
    });

    $("#save_button").on('click',function(){
        const id = $("#id").val();
        const name = $("#name").val();
        const address = $("#address").val();
        const tel = $("#tel").val();
        const email = $("#email").val();
        /*
        const description = $("#description").val();
        console.log(description);
        const photoPath = $("#photoPath").val();
        const idservices = $("custom-control-label").for();
        console.log(idservices);
        const services =  new Map();
        $("custom-control-input").val().each(function (index) {
            services.set( idservices[index] , $(this));
        });
        console.log(services);
        */
        $.ajax({
            type: "POST",
            data: {name : name, tel : tel, email : email, address : address},
            url: '/api/autoservice/short_update/'+id,
            dataType: 'text',
            success: function( data ) {
                console.log(data);
                $('div.modal-header').replaceWith(data);
                if(!data.includes('badmessageedit')){
                    $.ajax({
                        type: "GET",
                        url: '/api/autoservice/showAllFragment',
                        success: function( data ) {
                            console.log(data);
                            $('#for-replace').replaceWith(data);
                        }
                        ,
                        error: function (data) {
                            console.log(data);
                        },
                        complete: function (data) {
                            console.log(data);
                        },
                        ajaxError: function (data) {
                            console.log(data);
                        }
                    });
                }
            },
            error: function (data) {
                console.log(data);
            },

            complete: function (data) {
                console.log(data);
            },
            ajaxError: function (data) {
                console.log(data);
            }
        });
    });
});