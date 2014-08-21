<?php

/**
 * Provides a mail system class useful for debugging mail output.
 *
 * Usage in settings.php:
 * @code
 * $conf['mail_system']['default-system'] = 'MailDebugMailLog';
 * @endcode
 */
class MailDebugMailLog extends DefaultMailSystem {

  /**
   * Overrides DefaultMailSystem::mail().
   *
   * Accepts an e-mail message and displays it on screen, and additionally logs
   * it to watchdog().
   */
  public function mail(array $message) {
    $header = "To: {$message['to']} <br />Subject: {$message['subject']}";
    $string = nl2br(check_plain($message['body']));
		drupal_set_message($header . '<hr><br />' . $string.'</hr>');

    // Don't actually use debug to display the message since we want to be able
    // to categorize the watchdog type as 'mail' so it can be filterable in
    // UI.
    watchdog('mail', $header . '<br /><br />' . $string, NULL, WATCHDOG_INFO);

    return TRUE;
  }
}
