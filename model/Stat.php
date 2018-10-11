<?php

class Stat extends ActiveRecord\Model{

    static $table_name = 'stats';
    static $before_save = ['dup_check'];
    static $belongs_to = ['company'];

    public function dup_check(){
        if($this->id) $check = Stat::find(['conditions' => ['company_id = ? AND date = ? AND id <> ?', $this->company_id, $this->date->format('Y-m-d'), $this->id]]);
        else $check = Stat::find(['conditions' => ['company_id = ? AND date = ?', $this->company_id, $this->date->format('Y-m-d')]]);
        return ($check ? FALSE : TRUE);
    }

    public static function load_rows($payload){
        $filters = $payload['filters']; // from front end

        // build sql query from filters
        $sql_parts = [];
        $params = [];
        foreach($filters as $filter){
            if(!empty($filter['value'])){
                $params[] = $filter['value']; // set value
                // set conditions and logic based on attribute
                switch($filter['name']){
                    case "company_id":
                        $sql_parts[] = "company_id = ?";
                        break;
                    case "date_after":
                        $sql_parts[] = "date > ?";
                        break;
                    case "date_before":
                        $sql_parts[] = "date < ?";
                        break;
                }
            }
        };

        $results = Stat::all(['conditions' => array_merge(implode(" AND ", $sql_parts), $params)]); // query DB

        // format rows for hands on table
        $response = [];
        foreach($results as $result) $response[] = static::sheet_row([$result->company->ticker, $result->date->format('Y-m-d'), $result->close, $result->web, 'Synced']);
        return $response;

    }

    public static function verify_rows($payload){
        $rows = static::trim_blanks($payload['rows']);
        $response = [];
        $verified_tickers = [];
        foreach($rows as $row){
            if(array_key_exists($row[0], $verified_tickers)){
                $company = $verified_tickers[$row[0]];
            }else{
                $company = Company::find(['conditions' => ['ticker LIKE ?', $row[0]]]);
                if($company) $verified_tickers[$row[0]] = $company;
            }
            if($company){
                $existing = static::find(['conditions' => ['company_id = ? AND date = ?', $company->id, $row[1]]]);
                if($existing){
                    if($exisitng->close == $row[2] && $existing->web == $row[3]){
                        $status = "Synced";
                    }else{
                        $status = "Overwriting Existing Data";
                    }
                }else{
                    $status = "New Line";
                }
            }else{
                $status = "New Ticker, New Line";
            }
            $response[] = static::sheet_row([$row[0], $row[1], $row[2], $row[3], $status]);
        }
        return $response;
    }

    public static function save_rows(){
        $rows = static::trim_blanks($payload['rows']);
        $response = [];
        $verified_tickers = [];
        foreach($rows as $row){
            if(array_key_exists($row[0], $verified_tickers)){
                $company = $verified_tickers[$row[0]];
            }else{
                $company = Company::find(['conditions' => ['ticker LIKE ?', $row[0]]]);
                if($company) $verified_tickers[$row[0]] = $company;
            }
            if($company){
                $existing = static::find(['conditions' => 'company_id = ? AND date = ?', $company->id, $row[1]]);
                if($existing){
                    $existing->company_id = $company->id;
                    $existing->date = $row[1];
                    $existing->close = $row[2];
                    $existing->web = $row[3];
                    $status = ($existing->save() ? 'Synced' : 'Save Error');
                }else{
                    $new = new Stat([
                        'company_id' => $company->id,
                        'date' => $row[1],
                        'close' => $row[2],
                        'web' => $row[3]
                    ]);
                    $status = ($new->save() ? 'Synced' : 'Save Error');
                }
            }else{
                $company = new Company([
                    'ticker' => $row[0]
                ]);
                if($company->save()){
                    $verified_tickers[$company->ticker] = $company->id;
                    $new = new Stat([
                        'company_id' => $company->id,
                        'date' => $row[1],
                        'close' => $row[2],
                        'web' => $row[3]
                    ]);
                    $status = ($new->save() ? 'Synced' : 'Save Error');
                }else{
                    $status = 'Ticker Save Error,';
                }
            }
            $response[] = static::sheet_row([$row[0], $row[1], $row[2], $row[3], $status]);
        }
        return $response;
    }

    public static function load_sheet_data($payload){
        $col_data = [];

        //ticker col
        $col = new stdClass();
        $col->data = 'ticker';
        $col->type = 'dropdown';
        $col->source = [];
        foreach(Company::all() as $opt) array_push($col->source, $opt->ticker);
        array_push($col_data, $col);

        //date col
        $col = new stdClass();
        $col->data = 'date';
        $col->type = 'date';
        $col->dateFormat = 'YYYY-MM-DD';
        array_push($col_data, $col);

        // close col
        $col = new stdClass();
        $col->data = 'close';
        $col->type = 'numeric';
        array_push($col_data, $col);

        // web col
        $col = new stdClass();
        $col->data = 'web';
        $col->type = 'numeric';
        array_push($col_data, $col);

        //status col
        $col = new stdClass();
        $col->data = 'status';
        $col->type = 'text';
        $col->readOnly = TRUE;
        array_push($col_data, $col);

        return $col_data;
    }

    public static function sheet_row($row_arr){
        $row = new stdClass();
        $row->ticker = $row_arr[0];
        $row->date = $row_arr[1];
        $row->close = $row_arr[2];
        $row->web = $row_arr[3];
        $row->status = $row_arr[4];
        return $row;
    }

    public static function trim_blanks($rows){
        $response = [];
        foreach($rows as $row) if(!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3])) $response[] = $row;
        return $response;
    }

}
