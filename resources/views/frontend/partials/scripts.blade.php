<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-market-ticker]').forEach((ticker) => {
    const items = Array.from(ticker.querySelectorAll('[data-market-item]'));
    if (items.length < 2) return;
    let index = 0;
    window.setInterval(() => {
      items[index]?.classList.remove('is-active');
      index = (index + 1) % items.length;
      items[index]?.classList.add('is-active');
    }, 4500);
  });
});
</script>
