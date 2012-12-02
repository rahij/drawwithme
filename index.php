<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
var cur_x, cur_y;
$("document").ready(function(){
    var container = document.getElementById('canvas');
    init(container, screen.width-50, screen.height-150, '#ddd');
});

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

function createCanvas(parent, width, height) {
        var canvas = {};
        canvas.node = document.createElement('canvas');
        canvas.context = canvas.node.getContext('2d');
        canvas.node.width = width || 100;
        canvas.node.height = height || 100;
        parent.appendChild(canvas.node);
        return canvas;
}

function init(container, width, height, fillColor) {
    var canvas = createCanvas(container, width, height);
    var ctx = canvas.context;
    ctx.fillStyle="#FF0000";
    ctx.lineWidth = 3;
    
    setInterval(function(){
        $.ajax({url: "get.php", data: {id: getUrlVars()["id"]}, success: function(data){
            data = $.parseJSON(data);
            for(var i =0; i< data.length; ++i)
            {
                var cur_path = data[i];
                ctx.beginPath();
                ctx.moveTo(parseInt(cur_path["x1"]), parseInt(cur_path["y1"]));
                ctx.lineTo(parseInt(cur_path["x2"]), parseInt(cur_path["y2"]));
                ctx.stroke();
                console.log(typeof parseInt(cur_path["x1"]));
            }
        }});
    },500);

    ctx.clearTo = function(fillColor) {
        ctx.fillStyle = fillColor;
        ctx.fillRect(0, 0, width, height);
    };

    canvas.node.onmousemove = function(e) {
        if (!canvas.isDrawing) {
            return;
        }
        var x = e.pageX - this.offsetLeft;
        var y = e.pageY - this.offsetTop;
        var id = getUrlVars()["id"];
        $.post("add.php",{sessions_id : id, x1: cur_x, y1: cur_y, x2: x, y2: y});
        ctx.beginPath();
        ctx.moveTo(cur_x, cur_y);
        ctx.lineTo(x, y);
        ctx.stroke();
        cur_x = x;
        cur_y = y;
    };
    
    canvas.node.onmousedown = function(e) {
        var x = e.pageX - this.offsetLeft;
        var y = e.pageY - this.offsetTop;
        ctx.beginPath();
        ctx.moveTo(x,y);
        ctx.lineTo(x,y);
        ctx.stroke();
        cur_x = x;
        cur_y = y;
        canvas.isDrawing = true;
    };
    canvas.node.onmouseup = function(e) {
        canvas.isDrawing = false;
    };
}
</script>

<div id="canvas" style="border: 1px solid black"></div>
