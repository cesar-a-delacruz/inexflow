<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{
    protected $table            = 'businesses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    // protected $protectFields    = true;
    protected $allowedFields    = [
        'business_name',
        'owner_name',
        'owner_email',
        'owner_phone',
        'tax_id',
        'address',
        'logo_url',
        'onboarding_completed',
        'status',
        'registered_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'owner_email' => 'valid_email',
        'status'      => 'in_list[active,inactive,suspended]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Relación con el usuario registrador
    public function registrar()
    {
        return $this->belongsTo(UserModel::class, 'registered_by');
    }

    // Relación con usuarios asociados
    public function users()
    {
        return $this->hasMany(UserModel::class, 'business_id');
    }
}
