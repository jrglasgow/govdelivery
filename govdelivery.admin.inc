<?php

/**
 * @file
 * GovDelivery TMS admin UI.
 */

/**
 * Handle test settings form submission.
 */
function govdelivery_test_settings_submit($form, $postinfo) {
  $recipients = $postinfo['values']['govdelivery_test_settings']['recipients'];
  // Send message.
  if (isset($recipients) && !empty($recipients)) {
    $from = $postinfo['values']['govdelivery_test_settings']['from'];
    // Pass on the list to be sent.
    if (!empty($from)) {
      $status = govdelivery_send_test_message($recipients, $from);
    }
    else {
      $status = govdelivery_send_test_message($recipients);
    }
  }
  drupal_set_message(t('Your test message has been sent.'));
}

/**
 * Send a test message.
 *
 * @param string $send_to
 *   Email address to send to.
 *
 * @return array
 *   Email data.
 */
function govdelivery_send_test_message($send_to, $from = NULL) {
  dpm(__function_);
  //return drupal_mail('govdelivery', 'test_id', $send_to, language_default(), array(), $from, TRUE);
}

/**
 * Signup an email address for a specified list.
 *
 * Pass any known questions and answers along.
 *
 * @return array
 *   Test subscriptions form.
 */
function govdelivery_test_subscriptions($form, &$form_state) {
  $form = array(
    'govdelivery_test_subscriptions' => array(
      '#type' => 'fieldset',
      '#title' => t('GovDelivery settings test - subscriptions'),
      '#tree' => TRUE,
      'subscriber' => array(
        '#type' => 'textfield',
        '#title' => t("Subscriber's e-mail"),
      ),
      'list_code' => array(
        '#type' => 'textfield',
        '#title' => t('Subscription list code'),
      ),
      // Use Queue option.
      'test' => array(
        '#type' => 'submit',
        '#value' => t('Send test message'),
      ),
    ),
  );
  return $form;
}

/**
 * Validate number of subscribers.
 *
 * Need validation that there is only one subscriber or change to handle
 * multiple subscriptions.
 */
function govdelivery_test_subscriptions_submit($form, $postinfo) {
  $subscriber = $postinfo['values']['govdelivery_test_subscriptions']['subscriber'];
  $list_code = $postinfo['values']['govdelivery_test_subscriptions']['list_code'];

  // Commented code:
  // if (isset($subscriber) && !empty($subscriber) &&
  // isset($list_code) && !empty($list_code)) {
  $status = govdelivery_subscribe($list_code, $subscriber, FALSE);
  // }
  drupal_set_message(t('%response', array('%response' => $status ? 'Subscription added.' : 'Subscription failed.')));
}
