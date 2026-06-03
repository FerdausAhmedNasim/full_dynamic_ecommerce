@if (session('success'))
    <script type="module"> notify("{{ session('success') }}", 'success');</script>
@elseif (session('error'))
    <script type="module"> notify("{{ session('error') }}", 'danger');</script>
@endif
