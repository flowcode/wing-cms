var menuSate = 'closed';

var backgrounds = new Array();
var backgroundsIndex = 0;
var promoTime = 7000;
var promoRunning = true;
var timerID;

var disqus_shortname = 'naranjaestudio'; // required: replace example with your forum shortname

function toggleContent(){
    if(menuSate == 'closed'){
        openContent();
    }else{
        closeContent();
    }
}
function openContent(){
    if(menuSate == 'closed'){
        $("#btn-toggle-content").attr("src", "/img/btn-close.png");
        $("#content").css("width", "40%");
        menuSate = 'open';
    }
}
function closeContent(){
    if(menuSate == 'open'){
        $("#btn-toggle-content").attr("src", "/img/btn-open.png");
        $("#content").css("width", "0%");
        $(".content").hide();
        menuSate = 'closed';
    }
}

function servicios(){
    openContent();
    $("title").html("Servicios - Naranja Estudio");
    $("meta[name=description]").attr("description", "Estos son los servicios que brindamos.");
    showContent('servicios');
    $("#servicios-description-doblaje").show();
}

/**
 * Show Portfolio contents
 */
function portfolio(type){
    
    openContent();
    
    $("title").html("Portfolio - Naranja Estudio");
    $("meta[name=description]").attr("description", "Portfolio de nuestros trabajos.");
    
    showContent('portfolio');
    
    $( ".videos-container" ).hide();
    switch(type){
        case '1col':
            $( "#videos1col" ).show();
            break;
        case '2col':
            $( "#videos2col" ).show();
            break;
        case '3col':
            $( "#videos3col" ).show();
            break;
        default:
            $( "#videos1col" ).show();
    }
    
    $.ajax({
        url: "/video/videos",
        dataType: "json",
        success: function(data){
            $(".videos-container").empty();
            $( "#videoTmpl" ).tmpl( data ).appendTo( ".videos-container" );            
            attachEvents();
        },
        error: function(a,b,c){
            console.log(a);
        }
    });
    
    $.ajax({
        url: "/video/categorys",
        dataType: "json",
        success: function(data){
            $("#video-categorys").empty();
            $( "#categoryTmpl" ).tmpl( data ).appendTo( "#video-categorys" );
        },
        error: function(a,b,c){
            console.log(a);
        }
    });
    
    
    
}

/**
 * 
 */
function showServicio(id){
    $(".servicios-description").hide();
    $("#servicios-description-"+id).show();
}

function blog(){
    
    openContent();
    
    $("title").html("Blog - Naranja Estudio");
    $("meta[name=description]").attr("description", "Nuestro blog de noticias y novedades.");
    
    showContent('blog');
    
    $.ajax({
        url: "/blog/posts",
        dataType: "json",
        success: function(data){
            $("#posts").empty();
            $( "#postTmpl" ).tmpl( data ).appendTo( "#posts" );
            $.getScript ("http://" + disqus_shortname + ".disqus.com/count.js");

        },
        error: function(a,b,c){
            console.log(a);
        }
    });
}

function naranja(){
    openContent();
    
    $("title").html("Nosotros - Naranja Estudio");
    $("meta[name=description]").attr("description", "Somos un grupo de profesionales del campo audiovisual, con la experiencia y  entusiasmo necesarios para hacer realidad tus proyectos de Broad casting.");
    
    showContent('naranja');
}
function contacto(){
    openContent();
    
    $("title").html("Contacto - Naranja Estudio");
    $("meta[name=description]").attr("description", "Contacto con nosotros.");
    
    showContent('contact');
    createContact();
}

function createContact(){
    $.ajax({
        url: "/contact/",
        dataType: "html",
        success: function(data){
            $("#contact").empty();
            $("#contact").append(data);
            
        },
        error: function(a,b,c){
            console.log(a);
        }
    });
}

function showPost(postId){
    $("#post-body").height($(window).height());
    $("#post-body").width($("#content").width());
    $("#post-body").fadeIn();
    $.ajax({
        url: "/blog/post/"+postId,
        dataType: "html",
        success: function(data){
            $("#post-body").append(data);
        },
        error: function(a,b,c){
            console.log(a);
        }
    });
}
function hidePost(){
    $("#post-body").fadeOut();
    $("#post-body").empty();
}

function filterVideos(idCategory){
    $.ajax({
        url: "/video/videos/category/"+idCategory,
        dataType: "json",
        success: function(data){
            $(".videos-container").empty();
            $( "#videoTmpl" ).tmpl( data ).appendTo( ".videos-container" );
            attachEvents();
        },
        error: function(a,b,c){
            console.log(a);
        }
    });
}

function attachEvents(){
    $(".video").mouseenter(function(){
        $(this).children().children(".slot-content-slide").stop().fadeIn('slow');
    });
    $(".video").mouseleave(function(){
        $(this).children().children(".slot-content-slide").stop().fadeOut('slow');
    });    
}

function showContent(contentId){
    $(".content").hide();
    $("#" + contentId + "-content").show();
    console.log(contentId);
}

function setOverlay(fn){
    $("body").append("<div id='overlay'></div>");
    
    $("#overlay").click(function(){
        fn();
        unsetOverlay();
    });
}
function unsetOverlay(){
    $("#overlay").remove();
}

function openPlayer(idvideo){
    setOverlay(closePlayer);
    var video    = '<iframe width="560" height="315" ';
    video       +=      'src="http://www.youtube.com/embed/' + idvideo + '"';
    video       +=      ' frameborder="0" allowfullscreen controls="0" ';
    video       += '</iframe>';
    // set video content
    $("#flowplayer-video").append(video);
    $("#flowplayer").center();
    $("#flowplayer").fadeIn();
}
function closePlayer(){
    $("#flowplayer-video").empty();
    $("#flowplayer").hide();
}


jQuery.fn.center = function () {
    this.css("top", Math.max(0, (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft()) + "px");
    return this;
}

function updateContent(){
    $("#content").height($(window).height());
    if($("#flowplayer").is(":visible")){
        $("#flowplayer").center();
    }
}

function sendForm(){

    $.ajax({
        url: "/contact/contactar",
        type: "POST",
        data: {
            nombre : document.getElementsByName("nombre")[0].value,
            apellido : document.getElementsByName("apellido")[0].value,
            asunto : document.getElementsByName("asunto")[0].value,
            mail : document.getElementsByName("mail")[0].value,
            cuerpo : document.getElementsByName("cuerpo")[0].value
        },
        success: function(data){
            $("#contact").empty();
            $( "#contact" ).append(data);
            updateContent();
        },
        error: function(a,b,c){
            console.log(a);
        }
    });
}


var backgroundsArray = new Array();
backgroundsArray.push("/img/NARANJA_FONDO_01.png");
backgroundsArray.push("/img/NARANJA_FONDO_02.png");
backgroundsArray.push("/img/NARANJA_FONDO_03.png");


function initBG(){
    for(var i=0;i<backgroundsArray.length;i++){
        var img = new Image();
        img.src = backgroundsArray[i];
        backgrounds.push(img);
        var item = "<a id='bg-item-"+i+"' onclick='switchToBG("+i+")' class='bg-item' style=\"background-image: url('" + img.src + "');\">";
        item += "</a>";
        $("#bg-switch").append(item);
    }
    
}

function switchToBG(index){
    backgroundsIndex = index;
    updateBg();
}

function updateBg(){
    var img = backgrounds[backgroundsIndex];
    $("body").css("background-image", "url('"+img.src+"')");
    $(".bg-item").removeClass("active");
    $("#bg-item-"+backgroundsIndex).addClass("active");
}

function switchBG(){
    if(backgroundsIndex<backgrounds.length-1){
        backgroundsIndex++;
    }else{
        backgroundsIndex = 0;
    }
    updateBg();
}

function playPause(){
    if(promoRunning){
        stopLoop();
    }else{
        startLoop();
    }
}
        
function startLoop(){
    function promoLoop(){
        promoRunning = true;
        switchBG();
    }
    stopLoop();
    timerID=setInterval(promoLoop, promoTime);
}

function stopLoop(){
    clearInterval(timerID);
    promoRunning = false;
}

$(document).ready(function(){
    $(window).resize(function(){
        updateContent();
    });
    updateContent();
    initBG();
    switchToBG(0);
    startLoop();
})