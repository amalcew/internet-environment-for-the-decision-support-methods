<div>
    <p>{{ $title }}</p>
</div>
<div id="all_graph" style="width: 100%;height: 100%;">

</div>
<script>
    var graphData = {!! json_encode($graph) !!};
    var id = 'all_graph';
</script>

