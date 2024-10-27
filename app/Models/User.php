<?php

namespace App\Models;

class User {
    // 基本情報
    private $id;
    private $name;
    private $username;
    private $email;
    private $password;

    // 認証情報
    private $isActive;
    private $isAdmin;
    private $lastLogin;

    // プロフィール情報
    private $profilePicture;
    private $dateOfBirth;
    private $address;
    private $phoneNumber;
    private $bio;

    // セキュリティ
    private $passwordResetToken;
    private $twoFactorEnabled;
    private $failedLoginAttempts;
    private $accountLocked;

    // 日時情報
    private $createdAt;
    private $updatedAt;

    // ロールと権限
    private $role;
    private $permissions = [];

    // 通知設定
    private $emailNotifications;
    private $smsNotifications;
    private $pushNotifications;

    // ログイン関連
    private $oauthProvider;
    private $oauthToken;
    private $sessionToken;

    // 活動履歴
    private $activityLog = [];
    private $lastActivity;

    // サブスクリプション・課金情報
    private $subscriptionPlan;
    private $paymentMethod;
    private $billingAddress;

    // コンストラクタ
    public function __construct($id, $username, $email, $password, $name)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->name = $name;
        $this->createdAt = date('Y-m-d H:i:s');
        $this->isActive = true; // デフォルトでアクティブ
        $this->isAdmin = false; // デフォルトで一般ユーザー
    }

    // 基本情報の取得・設定
    public function getId() {
        return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }

    // パスワード関連
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function checkPassword($password) {
        return password_verify($password, $this->password);
    }

    // 認証情報
    public function getLastLogin() {
        return $this->lastLogin;
    }
    public function setLastLogin($lastLogin) {
        $this->lastLogin = $lastLogin;
    }
    public function isActive() {
        return $this->isActive;
    }
    public function deactivate() {
        $this->isActive = false;
    }

    // プロフィール情報
    public function getProfilePicture() { return $this->profilePicture; }
    public function setProfilePicture($profilePicture) { $this->profilePicture = $profilePicture; }

    public function getDateOfBirth() { return $this->dateOfBirth; }
    public function setDateOfBirth($dateOfBirth) { $this->dateOfBirth = $dateOfBirth; }

    public function getAddress() { return $this->address; }
    public function setAddress($address) { $this->address = $address; }

    public function getPhoneNumber() { return $this->phoneNumber; }
    public function setPhoneNumber($phoneNumber) { $this->phoneNumber = $phoneNumber; }

    public function getBio() { return $this->bio; }
    public function setBio($bio) { $this->bio = $bio; }

    // セキュリティ
    public function setPasswordResetToken($token) { $this->passwordResetToken = $token; }
    public function getPasswordResetToken() { return $this->passwordResetToken; }

    public function enableTwoFactorAuth() { $this->twoFactorEnabled = true; }
    public function disableTwoFactorAuth() { $this->twoFactorEnabled = false; }
    public function isTwoFactorEnabled() { return $this->twoFactorEnabled; }

    public function incrementFailedLoginAttempts() { $this->failedLoginAttempts++; }
    public function resetFailedLoginAttempts() { $this->failedLoginAttempts = 0; }
    public function getFailedLoginAttempts() { return $this->failedLoginAttempts; }

    public function lockAccount() { $this->accountLocked = true; }
    public function unlockAccount() { $this->accountLocked = false; }
    public function isAccountLocked() { return $this->accountLocked; }

    // 通知設定
    public function enableEmailNotifications() { $this->emailNotifications = true; }
    public function disableEmailNotifications() { $this->emailNotifications = false; }
    public function areEmailNotificationsEnabled() { return $this->emailNotifications; }

    public function enableSmsNotifications() { $this->smsNotifications = true; }
    public function disableSmsNotifications() { $this->smsNotifications = false; }
    public function areSmsNotificationsEnabled() { return $this->smsNotifications; }

    public function enablePushNotifications() { $this->pushNotifications = true; }
    public function disablePushNotifications() { $this->pushNotifications = false; }
    public function arePushNotificationsEnabled() { return $this->pushNotifications; }

    // ログイン関連
    public function setOauthProvider($provider) { $this->oauthProvider = $provider; }
    public function getOauthProvider() { return $this->oauthProvider; }

    public function setOauthToken($token) { $this->oauthToken = $token; }
    public function getOauthToken() { return $this->oauthToken; }

    public function setSessionToken($token) { $this->sessionToken = $token; }
    public function getSessionToken() { return $this->sessionToken; }

    // 活動履歴
    public function addActivity($activity) {
        $this->activityLog[] = $activity;
    }

    public function getActivityLog() {
        return $this->activityLog;
    }

    public function setLastActivity($lastActivity) {
        $this->lastActivity = $lastActivity;
    }

    public function getLastActivity() {
        return $this->lastActivity;
    }

    // サブスクリプション・課金
    public function setSubscriptionPlan($plan) { $this->subscriptionPlan = $plan; }
    public function getSubscriptionPlan() { return $this->subscriptionPlan; }

    public function setPaymentMethod($method) { $this->paymentMethod = $method; }
    public function getPaymentMethod() { return $this->paymentMethod; }

    public function setBillingAddress($address) { $this->billingAddress = $address; }
    public function getBillingAddress() { return $this->billingAddress; }
}

?>
