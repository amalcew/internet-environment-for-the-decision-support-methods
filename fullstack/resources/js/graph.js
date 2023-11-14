var margin = {top: 10, right: 30, bottom: 30, left: 40},
    width = 928 - margin.left - margin.right,
    height = 680 - margin.top - margin.bottom;

// color scale
var colors = d3.scaleOrdinal(d3.schemeCategory10);

var svg = d3.select("#graph")
    .append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)

// arrows
svg.append('defs').append('marker')
    .attrs({'id':'arrowhead',
        'viewBox':'-0 -5 10 10',
        'refX':20,
        'refY':0,
        'orient':'auto',
        'markerWidth':15,
        'markerHeight':15,
        'xoverflow':'visible'})
    .append('svg:path')
    .attr('d', 'M 0,-5 L 10 ,0 L 0,5')
    .attr('fill', '#444')
    .style('stroke','none');

//d3.json("https://gist.githubusercontent.com/amalcew/e33827664b3f3be18bd1d0d418bff5ef/raw/85373b400cab7b710ccd505108282d93d8b34e03/data1.json", function(data) {
//d3.json("https://gist.githubusercontent.com/fancellu/2c782394602a93921faff74e594d1bb1/raw/8949dbd31a888ccdb128f0052eb363e8b6f81dde/graph.json", function(data) {
d3.json("https://raw.githubusercontent.com/holtzy/D3-graph-gallery/master/DATA/data_network.json", function(data) {
    var simulation = d3.forceSimulation(data.nodes)
        .force("link", d3.forceLink()
                .id(function(d) { return d.id; })
                .links(data.links)
            // .distance(200)
            // .strength(1)
        )
        .force("charge", d3.forceManyBody()
            .strength(-500)
        )
        .force("center", d3.forceCenter(width / 2, height / 2))
        .force("x", d3.forceX()
            // .strength(1)
        )
        .force("y", d3.forceY()
            // .strength(1)
        );

    // edges
    var link = svg
        .selectAll(".link")
        .data(data.links)
        .enter()
        .append("line")
        .attr('marker-end','url(#arrowhead)')
        .style("stroke", "#aaa")

    // nodes
    var node = svg
        .selectAll(".node")
        .data(data.nodes)
        .enter()
        .append("g")
        .call(d3.drag()
                .on("start", dragstarted)
                .on("drag", dragged)
            //.on("end", dragended)
        );
    node
        .append("circle")
        .attr("r", 15)
        .style("fill", function (d, i) {return colors(i);})
    // .style("fill", "#69b3a2")
    node
        .append("title")
        .text(d => d.id)
    node.append("text")
        .attr("dy", -15)
        .attr("dx", 15)
        .text(d => d.name);

    // -----------------------------------------------------------------------------------------------------------------
    // edges labels
    // -----------------------------------------------------------------------------------------------------------------
    // var edgepaths = svg.selectAll(".edgepath")
    //     .data(data.links)
    //     .enter()
    //     .append('path')
    //     .attrs({
    //         'class': 'edgepath',
    //         'fill-opacity': 0,
    //         'stroke-opacity': 0,
    //         'id': function (d, i) {return 'edgepath' + i}
    //     })
    //     .style("pointer-events", "none");

    // var edgelabels = svg.selectAll(".edgelabel")
    //     .data(data.links)
    //     .enter()
    //     .append('text')
    //     .style("pointer-events", "none")
    //     .attrs({
    //         'class': 'edgelabel',
    //         'id': function (d, i) {return 'edgelabel' + i},
    //         'font-size': 10,
    //         'fill': '#aaa'
    //     });

    // edgelabels.append('textPath')
    //     .attr('xlink:href', function (d, i) {return '#edgepath' + i})
    //     .style("text-anchor", "middle")
    //     .style("pointer-events", "none")
    //     .attr("startOffset", "50%")
    //     .text(function (d) {return d.type});

    // -----------------------------------------------------------------------------------------------------------------

    simulation
        .nodes(data.nodes)
        .on("tick", ticked);

    simulation.force("link")
        .links(data.links);

    function ticked() {
        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);

        node
            .attr("transform", function (d) {return "translate(" + d.x + ", " + d.y + ")";});

        // edgepaths.attr('d', function (d) {
        //     return 'M ' + d.source.x + ' ' + d.source.y + ' L ' + d.target.x + ' ' + d.target.y;
        // });
        //
        // edgelabels.attr('transform', function (d) {
        //     if (d.target.x < d.source.x) {
        //         var bbox = this.getBBox();
        //
        //         rx = bbox.x + bbox.width / 2;
        //         ry = bbox.y + bbox.height / 2;
        //         return 'rotate(180 ' + rx + ' ' + ry + ')';
        //     }
        //     else {
        //         return 'rotate(0)';
        //     }
        // });
    }

    function dragstarted(d) {
        if (!d3.event.active) simulation.alphaTarget(0.3).restart()
        d.fx = d.x;
        d.fy = d.y;
    }

    function dragged(d) {
        d.fx = d3.event.x;
        d.fy = d3.event.y;
    }

    function dragended(d) {
        if (!d3.event.active) simulation.alphaTarget(0);
        d.fx = undefined;
        d.fy = undefined;
    }
});
