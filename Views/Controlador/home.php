<section id="bem-vindo">
  <div class="my-3">
    <div class="d-flex align-items-center p-3 text-white-50 gradient-bg rounded box-shadow">
      <img class="mr-5" src="/Public/Images/logo.png" alt="AS Logo" width="50" height="50">
      <div class="lh-100 ms-5">
        <p class="mb-3 text-white lh-100 CormorantInfant">Olá <?= htmlspecialchars($_SESSION['name']) ?>, seja bem vindo!</p>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const toastElList = document.querySelectorAll('.meus-toasts .toast');
    toastElList.forEach(function(toastEl) {
      let toast = new bootstrap.Toast(toastEl, {
        autohide: false
      });
      toast.show();
    });
  });
</script>