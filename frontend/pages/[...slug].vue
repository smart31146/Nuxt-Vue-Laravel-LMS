<script setup>
const event = useRequestEvent();
setResponseStatus(event, 404, 'ページが見つかりません。');
</script>