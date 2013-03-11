var bgposLeft = 0;
var bgposTop = 0;
var bgsize = 100;
    
var plusLeft = function(){
    bgposLeft++;
    $(".crop-img").css('background-position', ( bgposLeft + "px " + bgposTop + "px"));
    $("#bgleft").val(bgposLeft);
}
var minusLeft = function(){
    bgposLeft--;
    $(".crop-img").css('background-position', ( bgposLeft + "px " + bgposTop + "px"));
    $("#bgleft").val(bgposLeft);
}
var plusTop = function(){
    bgposTop++;
    $(".crop-img").css('background-position', ( bgposLeft + "px " + bgposTop + "px"));
    $("#bgtop").val(bgposTop);
}
var minusTop = function(){
    bgposTop--;
    $(".crop-img").css('background-position', ( bgposLeft + "px " + bgposTop + "px"));
    $("#bgtop").val(bgposTop);
}
var plusSize = function(){
    bgsize++;
    $(".crop-img").css('background-size', ( bgsize + "%"));
    $("#bgsize").val(bgsize);
}
var minusSize = function(){
    bgsize--;
    $(".crop-img").css('background-size', ( bgsize + "%"));
    $("#bgsize").val(bgsize);
}
    
   
var intLoop = null;
function startLoop(fn){
    intLoop = setInterval(fn, 30);
}
function stopLoop(){
    clearInterval(intLoop);
}

$(document).ready(function(){
    $("#btn-left-plus").mousedown(function(){
        startLoop(plusLeft);
    }).mouseup(function(){
        stopLoop();
    });
    $("#btn-top-plus").mousedown(function(){
        startLoop(plusTop);
    }).mouseup(function(){
        stopLoop();
    });
    $("#btn-bgsize-plus").mousedown(function(){
        startLoop(plusSize);
    }).mouseup(function(){
        stopLoop();
    });
    $("#btn-left-minus").mousedown(function(){
        startLoop(minusLeft);
    }).mouseup(function(){
        stopLoop();
    });
    $("#btn-top-minus").mousedown(function(){
        startLoop(minusTop);
    }).mouseup(function(){
        stopLoop();
    });
        
    $("#btn-bgsize-minus").mousedown(function(){
        startLoop(minusSize);
    }).mouseup(function(){
        stopLoop();
    });
});
