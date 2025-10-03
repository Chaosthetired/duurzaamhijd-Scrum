<?php
class company_class {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Create (INSERT) a company using individual params (no arrays)
     */
    public function addCompany(
        $company_name,
        $emissions,
        $electricity,
        $source,
        $selected_type_id,
        $logo_id,
        $active = 0
    ) {
        $query = "INSERT INTO company_table (
                    company_name,
                    company_type,
                    company_emissions,
                    logo_id,
                    company_source,
                    company_electricity_use,
                    company_active
                  )
                  VALUES (
                    :company_name,
                    :company_type,
                    :company_emissions,
                    :logo_id,
                    :company_source,
                    :company_electricity_use,
                    :company_active
                  )";

        $this->pdo->query($query);
        $this->pdo->bind(':company_name',            $company_name);
        $this->pdo->bind(':company_type',            $selected_type_id);
        $this->pdo->bind(':company_emissions',       $emissions);
        $this->pdo->bind(':logo_id',                 $logo_id);
        $this->pdo->bind(':company_source',          $source);
        $this->pdo->bind(':company_electricity_use', $electricity);
        $this->pdo->bind(':company_active',          $active);

        $this->pdo->execute();
        return $this->pdo->lastInsertId();
    }

    /**
     * Read (SELECT) a single company by ID
     */
    public function getCompanyById($company_id)
    {
        $query = "SELECT
                    company_id,
                    company_name,
                    company_type,
                    company_emissions,
                    logo_id,
                    company_source,
                    company_electricity_use,
                    company_active
                  FROM company_table
                  WHERE company_id = :company_id";

        $this->pdo->query($query);
        $this->pdo->bind(':company_id', $company_id);
        $this->pdo->execute();

        return $this->pdo->getRow();
    }

    /**
     * Read (SELECT) all companies
     */
    public function getAllCompanies()
    {
        $query = "SELECT
                    company_id,
                    company_name,
                    company_type,
                    company_emissions,
                    logo_id,
                    company_source,
                    company_electricity_use,
                    company_active
                  FROM company_table
                  ORDER BY company_id";

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
