

$('#picbtn').click(function(){
   count();
    return false;
});

function count(){
    
    $.ajax({
        url:'/index/count',
        dataType: 'json',
        success: function(number){
           document.getElementById("picnmb").innerHTML ='Current number of uploaded pictures is ' + $.parseJSON(number);
        }
    });
}