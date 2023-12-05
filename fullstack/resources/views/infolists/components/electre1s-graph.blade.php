<div>
    <p>{{ $foo }}</p>
</div>
<div id="graph" style="width: 100%;height: 100%;">

</div>
<script>

    var id = '{{ $graphId }}';
    var graphExample = {{ json_decode($graphData) }};
    var graphData = {
        nodes: [
            {
                id: 1,
                name: "A"
            },
            {
                id: 2,
                name: "B"
            },
            {
                id: 3,
                name: "C"
            },
            {
                id: 4,
                name: "D"
            },
        ],
        links: [
            {
                source: 1,
                target: 2
            },
            {
                source: 2,
                target: 3
            },
            {
                source: 3,
                target: 4
            }
        ]
    }
</script>

