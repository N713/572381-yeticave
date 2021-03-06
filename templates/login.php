<form class="form container" action="login.php" method="post">
  <h2>Вход</h2>
  <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
  <div class="form__item <?= $classname; ?>">
    <label for="email">E-mail*</label>
    <?php $email = $fields['email'] ?? ''; ?>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $email; ?>">
    <span class="form__error"><?= $errors['email'] ?? ''; ?></span>
  </div>
  <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
  <div class="form__item form__item--last <?= $classname; ?>">
    <label for="password">Пароль*</label>
    <input id="password" type="text" name="password" placeholder="Введите пароль" value="">
    <span class="form__error"><?= $errors['password'] ?? ''; ?></span>
  </div>
  <button type="submit" class="button">Войти</button>
</form>
