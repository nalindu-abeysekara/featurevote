<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'key',
        'value',
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'key' => 'required|max_length[100]|is_unique[settings.key,id,{id}]',
    ];

    protected $validationMessages = [
        'key' => [
            'required'  => 'Setting key is required.',
            'is_unique' => 'This setting key already exists.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Default settings.
     */
    protected static array $defaults = [
        'site_name'           => 'FeatureVote',
        'site_description'    => 'Share your ideas and vote on features',
        'allow_registration'  => '1',
        'require_email_verify' => '0',
        'items_per_page'      => '20',
        'allow_anonymous_view' => '1',
        'default_status'      => 'open',
        'notify_admin_email'  => '',
        'brand_color'         => '#6366f1',
    ];

    /**
     * Get setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $setting = $this->where('key', $key)->first();

        if ($setting) {
            return $setting->value;
        }

        // Return from defaults or provided default
        return self::$defaults[$key] ?? $default;
    }

    /**
     * Set setting value.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setSetting(string $key, $value): bool
    {
        $existing = $this->where('key', $key)->first();

        if ($existing) {
            return $this->update($existing->id, ['value' => $value]);
        }

        return $this->insert(['key' => $key, 'value' => $value]) !== false;
    }

    /**
     * Get all settings as key-value array.
     *
     * @return array
     */
    public function getAll(): array
    {
        $settings = self::$defaults;
        $dbSettings = $this->findAll();

        foreach ($dbSettings as $setting) {
            $settings[$setting->key] = $setting->value;
        }

        return $settings;
    }

    /**
     * Set multiple settings at once.
     *
     * @param array $settings
     * @return bool
     */
    public function setMany(array $settings): bool
    {
        $this->db->transStart();

        foreach ($settings as $key => $value) {
            $this->setSetting($key, $value);
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Delete a setting.
     *
     * @param string $key
     * @return bool
     */
    public function remove(string $key): bool
    {
        $setting = $this->where('key', $key)->first();

        if ($setting) {
            return $this->delete($setting->id);
        }

        return true;
    }

    /**
     * Check if a setting exists.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->where('key', $key)->countAllResults() > 0
            || isset(self::$defaults[$key]);
    }

    /**
     * Get default settings.
     *
     * @return array
     */
    public static function getDefaults(): array
    {
        return self::$defaults;
    }

    /**
     * Initialize default settings in database.
     *
     * @return void
     */
    public function initializeDefaults(): void
    {
        foreach (self::$defaults as $key => $value) {
            if (!$this->where('key', $key)->first()) {
                $this->insert(['key' => $key, 'value' => $value]);
            }
        }
    }
}
