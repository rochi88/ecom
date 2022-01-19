<?php

namespace App\Http\Livewire\Bankend\Role;

use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{
    public $selectedRole ;
    public $name;
    public $slug;
    public $description;
    public $roles;
    public $approle;


    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->roles = Role::getAllRoles();
        // $this->selectedRole;
    }

    /**
     * updatedName
     *
     * @return void
     */
    public function updatedName()
    {
        $this->validate([
            'name' => 'required|min:3|unique:roles,name',
        ]);
        $this->slug = Str::slug($this->name);
    }

    /**
     * selecteRoleselected
     *
     * @return void
     */
    public function selecteRoleselected()
    {
        if($this->selectedRole == 'select'){
            $this->selectedRole = null;
            $this->emit('roleSelectChanged',null);
        }else{
            $this->selectedRole = 'select';
        }
    }

    /**
     * selecteRolesEmpty
     *
     * @return void
     */
    public function selecteRolesEmpty()
    {
        $this->selectedRole = null;
        $this->emit('roleSelectChanged',null);
    }


    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.bankend.role.create');
    }

    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|unique:roles,name',
            'slug' => 'required|unique:roles,slug',
            'description' => 'nullable',
        ]);

        $role  = Role::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);


        $this->name = '';
        $this->slug = '';
        $this->description = '';

        $this->roles = Role::getAllRoles();
        $this->approle = $role->id;
        $this->emit('roleSelectChanged',$this->approle);


        $this->selectedRole = 'select';

        $this->dispatchBrowserEvent('notify',[
            'type' => 'Success',
            'message' =>'Role Created successfully.',
        ]);
    }
}
