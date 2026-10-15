@php
    $clean = function ($v) use (&$clean) {
        if (!is_array($v)) {
            return $v;
        }
        $isList = array_keys($v) === range(0, count($v) - 1);
        $out = [];
        foreach ($v as $k => $x) {
            $x = $clean($x);
            if ($x === null || $x === '' || $x === []) {
                continue;
            }
            $out[$k] = $x;
        }
        return $isList ? array_values($out) : $out;
    };
@endphp
<script type="application/ld+json">{!! json_encode($clean($data), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>