<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class StudentsComponent extends Component
{
    //deklarasi property nama, address, email untuk menampung data dari form 
    public $name, $address, $email, $id_edit_student, $id_delete_student;    
    // deklarasi property data view student untuk menampung data 
    public $view_student_name, $view_student_address, $view_student_email;

    public function render()
    {
        // mengambil data semua student
        $data = Student::all();

        //mengembalikan nilai dengan menampilkan view student component + data student
        return view('livewire.students-component', ['students' => $data])
            ->layout('livewire.layouts.base');
    }

    public function viewStudentDetail($id)
    {
        // mengambil data student dari DB berdasarkan ID student 
        $data = Student::where('id', $id)->first();

        // memasukan nilai data ke dalam property view student 
        $this->view_student_name = $data->name;
        $this->view_student_address = $data->address;
        $this->view_student_email = $data->email;

        // dd($data);

        // menampilkan modal view student dengan mengirimkan Browser Event
        $this->dispatchBrowserEvent('show-view-student-modal');        
    }

    public function closeViewStudentModal()
    {
        $this->view_student_name = '';
        $this->view_student_address = '';
        $this->view_student_email = '';
    }

    public function storeStudentData()
    {
        //Validasi data dari form yang dikirimkan
        $this->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required|unique:students',
        ]);

        //menambahkan data Student ke database 
        $student = new Student();
        $student->name = $this->name;
        $student->address = $this->address;
        $student->email = $this->email;

        //menyimpan ke DB Student
        $student->save();

        session()->flash('pesan', 'Data siswa berhasil ditambahkan');

        $this->name = '';
        $this->address = '';
        $this->email = '';

        //menutup modal Add Student setelah proses simpan
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editDataStudent($id)
    {
        // mengambil data dari DB berdasarkan ID 
        $dataByID = Student::where('id', $id)->first();

        // memasukan nilai data ke dalam property view student 
        $this->name = $dataByID->name;
        $this->address = $dataByID->address;
        $this->email = $dataByID->email;
        $this->id_edit_student = $dataByID->id;

        // dd($dataByID);

        $this->dispatchBrowserEvent('show-edit-modal-student');
    }

    public function resetInputs()
    {
        $this->name = '';
        $this->address = '';
        $this->email = '';  
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function updateDataStudent()
    {
        $this->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required|unique:students,email,'. $this->id_edit_student,
        ]);

        //mengupdate data Student ke database 
        $student = Student::where('id', $this->id_edit_student)->first();
        $student->name = $this->name;
        $student->address = $this->address;
        $student->email = $this->email;

        //menyimpan ke DB Student
        $student->save();

        session()->flash('pesan', 'Data siswa berhasil diupdate');

        //menutup modal edit Student setelah proses update
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteConfirmation($id)
    {
        $this->id_delete_student = $id;

        $this->dispatchBrowserEvent('show-confirmation-delete-modal');
    }

    public function cancel()
    {
        $this->student_delete_id = '';
    }
    
    public function deleteDataStudent()
    {
        $student = Student::where('id', $this->id_delete_student)->first();
        $student->delete();
        
        session()->flash('pesan', 'Data siswa berhasil dihapus');
        
        //menutup modal edit Student setelah proses update
        $this->dispatchBrowserEvent('close-modal');
        $this->student_delete_id = '';
    }


}
