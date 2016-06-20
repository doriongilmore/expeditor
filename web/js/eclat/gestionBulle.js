/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var discours = true;
$().ready(function(){
    setTimeout(function(){
        if(discours)
            bonjour();
    },1000);
    
    $('#avatar_talc').on('click',function(){
        discours = false;
        $('#bulle_eclat').hide();
        setTimeout(function(){
            monNom();
        },500);
    });
});

function bonjour()
{
    $('#bulle_eclat').show();
    setTimeout(function(){
        if(discours)
        {
            $('#bulle_eclat').hide();
            eclat();
        }
    },3000);
}

function eclat()
{
    $('#bulle_eclat').attr('src', 'web/img/bulle_eclat.png');
    $('#bulle_eclat').show();
    setTimeout(function(){
        $('#bulle_eclat').hide();
    },3000);
}

function monNom()
{
    $('#bulle_eclat').attr('src', 'web/img/bulle_2.png');
    $('#bulle_eclat').show();
    setTimeout(function(){
        $('#bulle_eclat').hide();
    },5000);
}