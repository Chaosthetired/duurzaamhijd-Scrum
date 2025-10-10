<?php
class company_class {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Create (INSERT) a company using individual params (no arrays)
     */
    public function addCompany(array $data): int
        {
        // 1) Whitelist columns you actually allow to be set from PHP
        $allowed = [
            'company_name',
            'company_type',
            'company_emissions',
            'logo_id',
            'company_source',
            'company_electricity_use',
            'company_version',
            'company_status',
            'company_user_submit_id',
            'company_admin_reviewed_by_id',
            'company_reviewed_at',
            'company_active',
        ];

        // 2) Keep only allowed keys
        $data = array_intersect_key($data, array_flip($allowed));

        // 3) Defaults
        $defaults = [
            'company_user_submit_id'       => 0,          // guest
            'company_status'               => 'pending',
            'company_version'              => 1,
            'company_admin_reviewed_by_id' => null,
            'company_reviewed_at'          => null,
        ];
        $data = array_replace($defaults, $data);

        // 4) Build dynamic INSERT
        $cols        = array_keys($data);
        $placeholders= array_map(fn($c) => ':' . $c, $cols);

        // Add submitted_at as SQL NOW()
        $cols[]         = 'company_company_submited_at';
        $placeholders[] = 'NOW()';

        $sql = 'INSERT INTO company_table (' . implode(',', $cols) . ')
                VALUES (' . implode(',', $placeholders) . ')';

        $this->pdo->query($sql);

        // Bind values
        foreach ($data as $col => $val) {
            $this->pdo->bind(':' . $col, $val);
        }

        $this->pdo->execute();

        // Your abstraction has lastInsertId()
        return (int)$this->pdo->lastInsertId();
    }

/** Optional helper if you want the full row back right away */
    public function getCompanyById(int $company_id): array
    {
        $this->pdo->query('SELECT * FROM company_table WHERE company_id = :id');
        $this->pdo->bind(':id', $company_id);
        $this->pdo->execute();
        return $this->pdo->getRow(); // or fetch assoc via your abstraction
    }
    /**
     * Read (SELECT) all companies
     */
    public function getAllCompanies()
    {
        $query = "SELECT * FROM company_table";

        $this->pdo->query($query);
        $this->pdo->execute();

        return $this->pdo->getRows();
    }

    /**
     * Update (UPDATE) a company by ID using individual params (no arrays)
     */
    public function updateCompany(
        $company_id,
        $company_name,
        $company_type,
        $company_emissions,
        $logo_id,
        $company_source,
        $company_electricity_use,
        $company_active
    ) {
        $query = "UPDATE company_table
                  SET
                    company_name            = :company_name,
                    company_type            = :company_type,
                    company_emissions       = :company_emissions,
                    logo_id                 = :logo_id,
                    company_source          = :company_source,
                    company_electricity_use = :company_electricity_use,
                    company_active          = :company_active
                  WHERE company_id = :company_id";

        $this->pdo->query($query);
        $this->pdo->bind(':company_name',            $company_name);
        $this->pdo->bind(':company_type',            $company_type);
        $this->pdo->bind(':company_emissions',       $company_emissions);
        $this->pdo->bind(':logo_id',                 $logo_id);
        $this->pdo->bind(':company_source',          $company_source);
        $this->pdo->bind(':company_electricity_use', $company_electricity_use);
        $this->pdo->bind(':company_active',          $company_active);
        $this->pdo->bind(':company_id',              $company_id);

        $this->pdo->execute();
    }
}
