$(function() {
   

    initDialogWindow();
    
    
     $('#modal-dialog').on('shown.bs.modal', function (e) {

})
    
    
});


function initDialogWindow()
{
    $(".DialogUser").on( "click", function() {
        DialogUser($( this ).attr('href'));
        return false;
    });


    $(".DialogUserMin").on( "click", function() {
        DialogUserMin($( this ).attr('href'));
        return false;
    });




    $(".DialogUserSMin").on( "click", function() {
        DialogUserSMin($( this ).attr('href'));
        return false;
    });
}






function parseJson(){
    
    
}