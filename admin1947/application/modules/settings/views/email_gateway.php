<div class="card shadow-sm" style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 25px;">
  <div class="card-header bg-white d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
    <h5 class="mb-0" style="margin: 0; font-size: 16px; font-weight: 700; color: #0F172A;">
      <i class="fa fa-envelope text-primary"></i> Email Provider Configuration
    </h5>
    <!-- The AJAX Verification Button -->
    <button type="button" id="verifyGatewayBtn" class="btn btn-info btn-sm text-white" style="font-weight: 600;">
      <i class="fa fa-paper-plane"></i> Verify Gateway & Send Test
    </button>
  </div>
  <div class="card-body" style="padding: 20px;">
    <!-- Display AJAX response here instead of crashing -->
    <div id="verificationResult" class="alert d-none" style="display: none; white-space: pre-wrap; font-family: monospace; font-size: 12px; margin-bottom: 20px;"></div>

    <form id="emailSettingsForm" action="<?= base_url('settings/save_email') ?>" method="POST">
      <div class="form-group mb-3" style="margin-bottom: 15px;">
        <label style="font-weight: 600; color: #334155; font-size: 13px;">Active Email Provider</label>
        <?php $ep = $email_settings['email_provider'] ?? ($settings['email_provider']['value'] ?? 'smtp'); ?>
        <select name="email_provider" id="emailProviderSelect" class="form-control" style="border-radius: 6px;">
          <option value="smtp" <?= $ep === 'smtp' ? 'selected' : ''; ?>>Standard SMTP (Gmail, Hostinger, Custom)</option>
          <option value="sendgrid" <?= $ep === 'sendgrid' ? 'selected' : ''; ?>>SendGrid API</option>
          <option value="ses" <?= $ep === 'ses' ? 'selected' : ''; ?>>Amazon SES</option>
          <option value="mailgun" <?= $ep === 'mailgun' ? 'selected' : ''; ?>>Mailgun API</option>
          <option value="postmark" <?= $ep === 'postmark' ? 'selected' : ''; ?>>Postmark</option>
        </select>
      </div>

      <div class="row mb-3" style="margin-bottom: 15px;">
        <div class="col-md-6">
          <label style="font-weight: 600; color: #334155; font-size: 13px;">Default "From Name"</label>
          <input type="text" name="from_name" class="form-control" value="<?= htmlspecialchars($email_settings['mail_from_name'] ?? ($settings['mail_from_name']['value'] ?? 'Upchar Healthcare')); ?>" style="border-radius: 6px;">
        </div>
        <div class="col-md-6">
          <label style="font-weight: 600; color: #334155; font-size: 13px;">Default "From Email Address"</label>
          <input type="email" name="from_email" class="form-control" value="<?= htmlspecialchars($email_settings['mail_from_email'] ?? ($settings['mail_from_email']['value'] ?? 'noreply@upchar.info')); ?>" style="border-radius: 6px;">
        </div>
      </div>

      <hr style="border-top: 1px solid #e2e8f0; margin: 20px 0;">

      <h6 class="mb-3" style="font-size: 14px; font-weight: 700; color: #0F172A; margin-bottom: 15px;">
        <i class="fa fa-server text-primary"></i> SMTP Server Parameters
      </h6>

      <div class="row mb-3" style="margin-bottom: 15px;">
        <div class="col-md-4">
          <label style="font-weight: 600; color: #334155; font-size: 13px;">SMTP Host</label>
          <input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?= htmlspecialchars($email_settings['smtp_host'] ?? ($settings['smtp_host']['value'] ?? 'mail.upchar.info')); ?>" placeholder="mail.upchar.info" style="border-radius: 6px;">
        </div>
        <div class="col-md-4">
          <label style="font-weight: 600; color: #334155; font-size: 13px;">SMTP Port</label>
          <input type="number" name="smtp_port" id="smtp_port" class="form-control" value="<?= htmlspecialchars($email_settings['smtp_port'] ?? ($settings['smtp_port']['value'] ?? '587')); ?>" placeholder="587" style="border-radius: 6px;">
        </div>
        <div class="col-md-4">
          <label style="font-weight: 600; color: #334155; font-size: 13px;">Encryption Protocol</label>
          <?php $sc = $email_settings['smtp_crypto'] ?? ($settings['smtp_crypto']['value'] ?? 'tls'); ?>
          <select name="smtp_crypto" id="smtp_crypto" class="form-control" style="border-radius: 6px;">
            <option value="tls" <?= $sc === 'tls' ? 'selected' : ''; ?>>TLS (Port 587)</option>
            <option value="ssl" <?= $sc === 'ssl' ? 'selected' : ''; ?>>SSL (Port 465)</option>
            <option value="" <?= empty($sc) || $sc === 'none' ? 'selected' : ''; ?>>None (Port 25)</option>
          </select>
        </div>
      </div>

      <div class="row mb-4" style="margin-bottom: 20px;">
        <div class="col-md-6">
          <label style="font-weight: 600; color: #334155; font-size: 13px;">SMTP Username / Email</label>
          <input type="text" name="smtp_user" id="smtp_user" class="form-control" value="<?= htmlspecialchars($email_settings['smtp_user'] ?? ($settings['smtp_user']['value'] ?? 'noreply@upchar.info')); ?>" style="border-radius: 6px;">
        </div>
        <div class="col-md-6">
          <label style="font-weight: 600; color: #334155; font-size: 13px;">SMTP Password</label>
          <input type="password" name="smtp_pass" id="smtp_pass" class="form-control" placeholder="••••••••" style="border-radius: 6px;">
          <small class="text-muted" style="color: #64748b; font-size: 11px;">Leave blank to keep current saved password</small>
        </div>
      </div>

      <div class="alert alert-warning p-2 text-dark" style="background: #fffbeb; border: 1px solid #fef3c7; color: #92400e; padding: 10px 14px; border-radius: 6px; margin-bottom: 20px;">
        <i class="fa fa-info-circle"></i> Changes affect patient & doctor notifications immediately.
      </div>

      <button type="submit" class="btn btn-primary" style="font-weight: 600; border-radius: 6px;">
        <i class="fa fa-save"></i> Save Email Settings
      </button>
    </form>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#verifyGatewayBtn').click(function(e) {
    e.preventDefault();
    let btn = $(this);
    let origHtml = btn.html();
    let resultDiv = $('#verificationResult');

    btn.html('<i class="fa fa-spinner fa-spin"></i> Verifying...').prop('disabled', true);
    resultDiv.addClass('d-none').hide().removeClass('alert-success alert-danger').html('');

    $.ajax({
      url: "<?= base_url('settings/verify_gateway') ?>",
      type: "POST",
      data: $('#emailSettingsForm').serialize(),
      dataType: "json",
      timeout: 20000,
      success: function(response) {
        btn.html(origHtml).prop('disabled', false);
        resultDiv.removeClass('d-none').show();
        if(response && response.status === 'success') {
          resultDiv.addClass('alert-success').html('<strong><i class="fa fa-check-circle"></i> Success:</strong> ' + response.message);
          if (response.debug) {
            resultDiv.append('<pre style="margin-top:10px; font-size:11px; max-height:160px; overflow-y:auto;">' + response.debug + '</pre>');
          }
        } else {
          resultDiv.addClass('alert-danger').html('<strong><i class="fa fa-exclamation-triangle"></i> Failed:</strong> ' + ((response && response.message) ? response.message : 'Gateway verification failed.'));
          if (response && response.debug) {
            resultDiv.append('<pre style="margin-top:10px; font-size:11px; max-height:200px; overflow-y:auto;">' + response.debug + '</pre>');
          }
        }
      },
      error: function(xhr, status, errorThrown) {
        btn.html(origHtml).prop('disabled', false);
        resultDiv.removeClass('d-none').show().addClass('alert-danger');
        var msg = "Server Error: Could not complete the request. ";
        if (status === 'timeout') {
          msg = "Timeout: The SMTP server did not respond within 20 seconds.";
        } else if (xhr && xhr.responseText) {
          try {
            var parsed = JSON.parse(xhr.responseText);
            if (parsed.message) msg = parsed.message;
            if (parsed.debug) msg += '\n\n' + parsed.debug;
          } catch(err) {
            msg += (xhr.status ? 'HTTP ' + xhr.status + ': ' : '') + errorThrown;
          }
        }
        resultDiv.html(msg);
      }
    });
  });
});
</script>
