<?php
function validateFields($fields, $rules)
{ 
  $errors = array();
  
  // loop through rules
  for ($i=0; $i<count($rules); $i++)
  {
    // split row into component parts 
    $row = split(",", $rules[$i]);

    $satisfies_if_conditions = true;
    while (preg_match("/^if:/", $row[0]))
    {
      $condition = preg_replace("/^if:/", "", $row[0]);

      // check if it's a = or != test
      $comparison = "equal";
      $parts = array();
      if (preg_match("/!=/", $condition))
      {
        $parts = split("!=", $condition);
        $comparison = "not_equal";
      }
      else 
        $parts = split("=", $condition);

      $field_to_check = $parts[0];
      $value_to_check = $parts[1];
      
      // if the VALUE is NOT the same, we don't need to validate this field. Return.
      if ($comparison == "equal" && $fields[$field_to_check] != $value_to_check)
      {
        $satisfies_if_conditions = false;
        break;
      }
      else if ($comparison == "not_equal" && $fields[$field_to_check] == $value_to_check)
      {
        $satisfies_if_conditions = false;
        break;      
      }
      else 
        array_shift($row);    // remove this if-condition from line, and continue validating line
    }

    if (!$satisfies_if_conditions)
      continue;


    $requirement = $row[0];
    $field_name  = $row[1];

    // depending on the validation test, store the incoming strings for use later...
    if (count($row) == 6)        // valid_date
    {
      $field_name2   = $row[2];
      $field_name3   = $row[3];
      $date_flag     = $row[4];
      $error_message = $row[5];
    }
    else if (count($row) == 5)     // reg_exp (WITH flags like g, i, m)
    {
      $field_name2   = $row[2];
      $field_name3   = $row[3];
      $error_message = $row[4];
    }
    else if (count($row) == 4)     // same_as, custom_alpha, reg_exp (without flags like g, i, m)
    {
      $field_name2   = $row[2];
      $error_message = $row[3];
    }
    else
      $error_message = $row[2];    // everything else!


    // if the requirement is "length=...", rename requirement to "length" for switch statement
    if (preg_match("/^length/", $requirement))
    {
      $length_requirements = $requirement;
      $requirement         = "length";
    }

    // if the requirement is "range=...", rename requirement to "range" for switch statement
    if (preg_match("/^range/", $requirement))
    {
      $range_requirements = $requirement;
      $requirement        = "range";
    }


    // now, validate whatever is required of the field
    switch ($requirement)
    {
      case "required":
        if (!isset($fields[$field_name]) || $fields[$field_name] == "")
          $errors[] = $error_message;
        break;

      case "digits_only":       
        if (isset($fields[$field_name]) && preg_match("/\D/", $fields[$field_name]))
          $errors[] = $error_message;
        break;

      case "letters_only": 
        if (isset($fields[$field_name]) && preg_match("/[^a-zA-Z]/", $fields[$field_name]))
          $errors[] = $error_message;
        break;

      // doesn't fail if field is empty
      case "valid_email":
        $regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";     
        if (isset($fields[$field_name]) && !empty($fields[$field_name]) && !preg_match($regexp, $fields[$field_name]))
          $errors[] = $error_message;
        break;

      case "length":
        $comparison_rule = "";
        $rule_string     = "";

        if      (preg_match("/length=/", $length_requirements))
        {
          $comparison_rule = "equal";
          $rule_string = preg_replace("/length=/", "", $length_requirements);
        }
        else if (preg_match("/length>=/", $length_requirements))
        {
          $comparison_rule = "greater_than_or_equal";
          $rule_string = preg_replace("/length>=/", "", $length_requirements);
        }
        else if (preg_match("/length<=/", $length_requirements))
        {
          $comparison_rule = "less_than_or_equal";
          $rule_string = preg_replace("/length<=/", "", $length_requirements);
        }
        else if (preg_match("/length>/", $length_requirements))
        {
          $comparison_rule = "greater_than";
          $rule_string = preg_replace("/length>/", "", $length_requirements);
        }
        else if (preg_match("/length</", $length_requirements))
        {
          $comparison_rule = "less_than";
          $rule_string = preg_replace("/length</", "", $length_requirements);
        }

        switch ($comparison_rule)
        {
          case "greater_than_or_equal":
            if (!(strlen($fields[$field_name]) >= $rule_string))
              $errors[] = $error_message;
            break;
          case "less_than_or_equal":
            if (!(strlen($fields[$field_name]) <= $rule_string))
              $errors[] = $error_message;
            break;
          case "greater_than":
            if (!(strlen($fields[$field_name]) > $rule_string))
              $errors[] = $error_message;
            break;
          case "less_than":
            if (!(strlen($fields[$field_name]) < $rule_string))
              $errors[] = $error_message;
            break;
          case "equal":
            // if the user supplied two length fields, make sure the field is within that range
            if (preg_match("/-/", $rule_string))
            {
              list($start, $end) = split("-", $rule_string);
              if (strlen($fields[$field_name]) < $start || strlen($fields[$field_name]) > $end)
                $errors[] = $error_message;
            }
            // otherwise, check it's EXACTLY the size the user specified 
            else
            {
              if (strlen($fields[$field_name]) != $rule_string)
                $errors[] = $error_message;
            }     
            break;       
        }
        break;

      case "range":
        $comparison_rule = "";
        $rule_string     = "";

        if      (preg_match("/range=/", $range_requirements))
        {
          $comparison_rule = "equal";
          $rule_string = preg_replace("/range=/", "", $range_requirements);
        }
        else if (preg_match("/range>=/", $range_requirements))
        {
          $comparison_rule = "greater_than_or_equal";
          $rule_string = preg_replace("/range>=/", "", $range_requirements);
        }
        else if (preg_match("/range<=/", $range_requirements))
        {
          $comparison_rule = "less_than_or_equal";
          $rule_string = preg_replace("/range<=/", "", $range_requirements);
        }
        else if (preg_match("/range>/", $range_requirements))
        {
          $comparison_rule = "greater_than";
          $rule_string = preg_replace("/range>/", "", $range_requirements);
        }
        else if (preg_match("/range</", $range_requirements))
        {
          $comparison_rule = "less_than";
          $rule_string = preg_replace("/range</", "", $range_requirements);
        }
        
        switch ($comparison_rule)
        {
          case "greater_than":
            if (!($fields[$field_name] > $rule_string))
              $errors[] = $error_message;
            break;
          case "less_than":
            if (!($fields[$field_name] < $rule_string))
              $errors[] = $error_message;
            break;
          case "greater_than_or_equal":
            if (!($fields[$field_name] >= $rule_string))
              $errors[] = $error_message;
            break;
          case "less_than_or_equal":
            if (!($fields[$field_name] <= $rule_string))
              $errors[] = $error_message;
            break;
          case "equal":
            list($start, $end) = split("-", $rule_string);

            if (($fields[$field_name] < $start) || ($fields[$field_name] > $end))
              $errors[] = $error_message;
            break;
        }
        break;
        
      case "same_as":
        if ($fields[$field_name] != $fields[$field_name2])
          $errors[] = $error_message;
        break;

      case "valid_date":
        // this is written for future extensibility of isValidDate function to allow 
        // checking for dates BEFORE today, AFTER today, IS today and ANY day.
        $is_later_date = false;
        if    ($date_flag == "later_date")
          $is_later_date = true;
        else if ($date_flag == "any_date")
          $is_later_date = false;

        if (!is_valid_date($fields[$field_name], $fields[$field_name2], $fields[$field_name3], $is_later_date))
          $errors[] = $error_message;
        break;

      case "is_alpha":
        if (preg_match('/[^A-Za-z0-9]/', $fields[$field_name]))
          $errors[] = $error_message; 
        break;
        
      case "custom_alpha":
        $chars = array();
        $chars["L"] = "[A-Z]";
        $chars["V"] = "[AEIOU]";
        $chars["l"] = "[a-z]";
        $chars["v"] = "[aeiou]";
        $chars["D"] = "[a-zA-Z]";
        $chars["F"] = "[aeiouAEIOU]";
        $chars["C"] = "[BCDFGHJKLMNPQRSTVWXYZ]";
        $chars["x"] = "[0-9]";
        $chars["c"] = "[bcdfghjklmnpqrstvwxyz]";
        $chars["X"] = "[1-9]";
        $chars["E"] = "[bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ]";

        $reg_exp_str = "";
        for ($j=0; $j<strlen($field_name2); $j++)
        {
          if (array_key_exists($field_name2[$j], $chars))
            $reg_exp_str .= $chars[$field_name2[$j]];
          else
            $reg_exp_str .= $field_name2[$j];
        }

        if (!empty($fields[$field_name]) && !preg_match("/$reg_exp_str/", $fields[$field_name]))
          $errors[] = $error_message;
        break;

      case "reg_exp":
        $reg_exp_str = $field_name2;

        // rather crumby, but...
        if (count($row) == 5)
          $reg_exp = "/" . $reg_exp_str . "/" . $row[3]; 
        else
          $reg_exp = "/" . $reg_exp_str . "/"; 

        if (!empty($fields[$field_name]) && !preg_match($reg_exp, $fields[$field_name]))
          $errors[] = $error_message;
        break;

      default:
        die("Unknown requirement flag in validate_fields(): $requirement");
        break;
    }
  }
  
  return $errors;
}

function is_valid_date($month, $day, $year, $is_later_date)
{
  // depending on the year, calculate the number of days in the month
  if ($year % 4 == 0)      // LEAP YEAR 
    $days_in_month = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
  else
    $days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);


  // first, check the incoming month and year are valid. 
  if (!$month || !$day || !$year) return false;
  if (1 > $month || $month > 12)  return false;
  if ($year < 0)                  return false;
  if (1 > $day || $day > $days_in_month[$month-1]) return false;


  // if required, verify the incoming date is LATER than the current date.
  if ($is_later_date)
  {    
    // get current date
    $today = date("U");
    $date = mktime(0, 0, 0, $month, $day, $year);
    if ($date < $today)
      return false;
  }

  return true;
}

?>
