<?php
/**
 * @author Andre Luis Zipf (andrezipf94 at github dot com)
 * @since 05/08/17
 */
namespace Model;
class Job extends \Illuminate\Database\Eloquent\Model
{
    protected $primaryKey = "idjob";
    protected $fillable = ["name", "description", "requirements", "initial_salary"];
}