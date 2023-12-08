<div id="{{ $graphId  }}" style="width: 100%;height: 100%;">

</div>
<script>
    {{-- exclamation marks required to bypass sanitization --}}
    var graphData = {!! json_encode($graphData) !!};
    var id = '{{ $graphId  }}';
</script>

