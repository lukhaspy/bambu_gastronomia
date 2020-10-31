<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $employeeModel;

    public function __construct(Employee $employeeModel)
    {
        $this->employeeModel = $employeeModel;
    }

    public function index()
    {

        $employees = $this->employeeModel->paginate(25);

        return view('rrhh.employees.index', compact('employees'));
    }

    public function create()
    {


        return view('rrhh.employees.create');
    }

    public function store(EmployeeRequest $request)
    {

        $this->employeeModel->create($request->all());

        return redirect()->route('employees.index')->withStatus('Funcionario agregado correctamente.');
    }

    public function show(Employee $employee)
    {



        return view('rrhh.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {


        return view('rrhh.employees.edit', compact('employee'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {

        $employee->update($request->all());

        return redirect()->route('employees.index')->withStatus('Funcionario actualizado correctamente.');
    }

    public function destroy(Employee $employee)
    {

        $employee->delete();

        return redirect()->route('employees.index')->withStatus('Funcionario eliminado correctamente.');
    }
}
