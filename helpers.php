<?php

define('SESSION_TIMEOUT', 3600); // 1h

function loadEnv($path = '.env')
{
  if (!file_exists($path)) {
    throw new Exception("Arquivo .env não encontrado em {$path}");
  }

  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) {
      continue; // Ignora comentários
    }

    list($name, $value) = explode('=', $line, 2);
    $name = trim($name);
    $value = trim($value);

    if (!empty($name)) {
      putenv("{$name}={$value}");
    }
  }
}

function siteUrl()
{
  return getenv('SITE_URL');
}

function fld_url($caminho)
{
  $urlCompleta = getenv('SITE_URL') . '/' . $caminho;
  return $urlCompleta;
}


function token()
{
  return "<input type='hidden' name='csrf_token' value='" . generateCsrfToken() . "'>";
}

function logError($message)
{
  $dt = date('d/m/Y H:i:s');
  error_log("[ERRO] {$dt} - {$message}\r", 3, __DIR__ . "/logs/error.log");
}

// Apenas para verificar alguns arrays formatado
function fldPre($string, $die = false)
{
  echo '<pre>';
  print_r($string);
  echo '</pre>';
  if ($die) die;
}

/**
 *- $tipo : 0 -> criptografa
 *- $tipo : 1 -> descriptografa
 *- $caracter : Texto/Número
 */
function fldCrip($caracter, $tipo)
{
  $key = getenv('CRIP_KEY');
  $method = 'aes-256-gcm';
  if ($tipo == 0) {
    $tag = getenv('CRIP_TAG');
    $iv = getenv('CRIP_IV');
    $encrypted = openssl_encrypt(
      $caracter,
      $method,
      $key,
      OPENSSL_RAW_DATA,
      $iv,
      $tag
    );

    // IV + ciphertext + tag
    $combined = $iv . $encrypted . $tag;

    $safeEncrypted = rtrim(strtr(base64_encode($combined), '+/', '-_'), '=');
    return $safeEncrypted;
  } elseif ($tipo == 1) {
    $caracter = strtr($caracter, '-_', '+/');
    $caracter .= str_repeat('=', (4 - strlen($caracter) % 4) % 4);
    $decoded = base64_decode($caracter);

    $iv = substr($decoded, 0, 16);
    $ciphertext = substr($decoded, 16, -16);
    $tag = substr($decoded, -16);

    $decrypted = openssl_decrypt(
      $ciphertext,
      $method,
      $key,
      OPENSSL_RAW_DATA,
      $iv,
      $tag
    );
    return $decrypted;
  }
}

function fldMesBrasil($date)
{
  $meses = [
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
  ];
  return $meses[$date];
}

/**
 *- Transformar uma data 2025-11-25
 *- Em 25 Nov, 2025
 */
function fldDateExtenso($date)
{
  $timestamp = strtotime($date);
  $dia = date('d', $timestamp);
  $mes = date('m', $timestamp);
  $ano = date('Y', $timestamp);
  return "{$dia} de " . fldMesBrasil($mes) . ", {$ano}";
}

/**
 *- Transformar texto tipo -> Cartão IT Mozão em cartaoitmozao
 *- $texto -> texto a ser modificado
 */
function fldTirarAcento($texto)
{
  // Normaliza a string para remover acentos
  $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);

  // Remover espaços e caracteres especiais
  $texto = preg_replace('/[^a-zA-Z0-9]/', '', $texto);

  // Transformar em minúsculas
  return strtolower($texto);
}

function generateCsrfToken()
{
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

/**
 * 
 * - $iconName: checar o nome do icone no site https://fonts.google.com/icons
 * - $size: ... 24, 36, 48 ... ,
 * - $cor: text-primary text-secondary text-success, text-danger, text-warning, text-info, text-light, text-dark
 * - Usar em Botão => class: d-inline-flex align-items-center justify-content-center gap-2
 */
function fldIco($iconName, $size, $cor = null)
{
  // Validar o tamanho (opcional)
  if (!is_numeric($size) || $size <= 0) {
    throw new InvalidArgumentException("O tamanho do icone deve ser um número positivo.");
  }

  // Gerar o HTML do ícone com o tamanho especificado
  $html = sprintf(
    '<i class="material-symbols-outlined %s" style="font-size: %dpx;">%s</i>',
    $cor,
    $size,
    htmlspecialchars($iconName, ENT_QUOTES, 'UTF-8')
  );

  return $html;
}


function fldPopupMessage()
{
  if (isset($_SESSION['session_message'])) {
    $error = $_SESSION['session_message'];
    fldAlertaPersonalizado(
      $error['titulo'],
      $error['mensagem'],
      $error['icone'],
      'OK'
    );
    unset($_SESSION['session_message']);
  }
}

/**
 * Exibe a mensagem de sucesso como Toast se existir e a remove da sessão
 * 
 * @return void
 */
function fldTostMessage()
{
  if (isset($_SESSION['success_tost'])) {
    $success = $_SESSION['success_tost'];
    fldToastAlert(
      $success['mensagem'],
      'success',
      'center'
    );
    unset($_SESSION['success_tost']);
  }
}

/**
 ** Exibe o alerta com mensagem customizada
 *- Icones => success, error, warning, info, question
 *- titulo => Titulo da janela
 *- mensagem => Escreva a mensagem a ser exibida
 *- icone => escolha um Icon acima
 *- confirmButton => Texto do Botão
 */
function fldAlertaPersonalizado($titulo, $mensagem, $icone, $confirmButton)
{
  echo "
  <script>
    Swal.fire({
      icon: '$icone',
      title: '$titulo',
      text: '$mensagem',
      confirmButtonText: '$confirmButton',
      confirmButtonColor: '#5f5f5f',
      background: '#f9f9f9',
      color: '#333'
    });
  </script>
  ";
}

/**
 ** Exibe o alerta TOAST com mensagem customizada
 *- Icon => success, error, warning, info, question
 *- mensagem => Escreva a mensagem a ser exibida
 *- icone => escolha um Icon acima
 *- posicao => top, top-start, top-end, center, center-start, center-end, bottom, bottom-start, bottom-end
 */
function fldToastAlert($mensagem, $icone, $posicao)
{
  echo "
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: '$posicao',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });
    Toast.fire({
      icon: '$icone',
      title: '$mensagem'
    });
  </script>
  ";
}
