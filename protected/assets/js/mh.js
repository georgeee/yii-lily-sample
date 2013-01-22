var labelType, useGradients, nativeTextSupport, animate;

(function() {
    var ua = navigator.userAgent,
            iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
            typeOfCanvas = typeof HTMLCanvasElement,
            nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
            textSupport = nativeCanvasSupport
            && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
    //I'm setting this based on the fact that ExCanvas provides text support for IE
    //and that as of today iPhone/iPad current text support is lame
    labelType = (!nativeCanvasSupport || (textSupport && !iStuff)) ? 'Native' : 'HTML';
    nativeTextSupport = labelType == 'Native';
    useGradients = nativeCanvasSupport;
    animate = !(iStuff || !nativeCanvasSupport);
})();

function setMhInfo(node) {
    var $ = jQuery;
    var $info = $('#info');
    for (var key in node.data) {
        $info.find('dd.' + key).html(node.data[key]);
    }
}

//init Spacetree
//Create a new ST instance
st = new $jit.ST({
    //id of viz container element
    injectInto: 'infovis',
    //set duration for the animation
    duration: 800,
    //set animation transition type
    transition: $jit.Trans.Quart.easeInOut,
    //set distance between node and its children
    levelDistance: 40,
    //sibling and subtrees offsets
    siblingOffset: 3,
    subtreeOffset: 3,
    //enable panning
    Navigation: {
        enable: true,
        panning: true
    },
    //set node and edge styles
    //set overridable=true for styling individual
    //nodes or edges
    Node: {
        height: 35,
        width: 50,
        type: 'ellipse',
        color: '#aaa',
        overridable: true,
        //set canvas specific styles
        //like shadows
        CanvasStyles: {
            shadowColor: '#ccc',
            shadowBlur: 10
        }
    },
    Edge: {
        type: 'line',
        overridable: true
    },
    //This method is called on DOM label creation.
    //Use this method to add event handlers and styles to
    //your node.
    onCreateLabel: function(label, node) {
        label.id = node.id;
        label.innerHTML = node.name;
        label.onclick = function() {
            setMhInfo(node);
            st.onClick(node.id);
        };
        //set label styles
        var style = label.style;
        style.width = 50 + 'px';
        style.height = 35 + 'px';
        style.cursor = 'pointer';
        style.color = '#333';
        style.fontSize = '0.8em';
        style.textAlign = 'center';
        style.paddingTop = '10px';
    },
    //This method is called right before plotting
    //a node. It's useful for changing an individual node
    //style properties before plotting it.
    //The data properties prefixed with a dollar
    //sign will override the global node style properties.
    onBeforePlotNode: function(node) {
        //add some color to the nodes in the path between the
        //root node and the selected node.
        if (node.selected) {
            node.data.$color = "#ff7";
        } else {
            delete node.data.$color;
        }
    },
    //This method is called right before plotting
    //an edge. It's useful for changing an individual edge
    //style properties before plotting it.
    //Edge data proprties prefixed with a dollar sign will
    //override the Edge global style properties.
    onBeforePlotLine: function(adj) {
        if (adj.nodeFrom.selected && adj.nodeTo.selected) {
            adj.data.$color = "#eed";
            adj.data.$lineWidth = 3;
        }
        else {
            delete adj.data.$color;
            delete adj.data.$lineWidth;
        }
    }
});
//load json data
st.loadJSON(mhData);
//compute node positions and layout
st.compute();
//optional: make a translation of the tree
st.geom.translate(new $jit.Complex(-200, 0), "current");
//emulate a click on the root node.
st.onClick(st.root);
//end

setMhInfo(mhData);
