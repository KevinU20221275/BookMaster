const URL = '../../Controllers/roleController.php'


export async function listRoles() {

    let formData = new FormData();
    formData.append('action', 'ListRoles');
    
    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData,
            cache: "no-store"
        })

        return await res.text()

    } catch (error) {
        console.log(error)
    }
}

export async function addRole(formData) {
    formData.append("action", 'Create');

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
        
        const data = await res.json()
    
        return data
    } catch (error) {
        console.log(error)
    }
}

export async function getRoleById(id) {
    let formData = new FormData()
    formData.append('id', id)
    formData.append('action', "GetRoleById")

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
        
        if (res.ok){
            return await res.json()
        } else {
            throw new Error('Error al obtener los datos')
        }        
    } catch (error) {
        console.log(error)
    }
}

export async function editRole(formData){
    formData.append('action', 'Update')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
    
        if (res.ok){
            return await res.json()
        } else {
            throw new Error("Error al obtener los datos")
        }
        
    } catch (error) {
        console.log(error)
    }
}

export async function deleteRole(formData) {
    formData.append('action', 'Delete')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
        
        if (res.ok) {
            return await res.json()
        } else {
            throw new Error('Error al eliminar el rol')
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
}