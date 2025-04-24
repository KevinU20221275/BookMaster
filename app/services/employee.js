const URL = "../../Controllers/employeeController.php";

export async function listEmployees() {
    let formData = new FormData();
    formData.append('action', 'ListEmployees');
    
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

export async function addEmployee(formData){
    formData.append("action", 'Create');

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){
            return await res.json()
        } else {
            const data = await res.json()
            throw new Error(data.message)
        }
    } catch (error) {
        return {status: "error", message : error.message}
    }
} 


export async function getEmployeeById(id) {
    let formData = new FormData()
    formData.append('id', id)
    formData.append('action', "GetEmployeeById")

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){    
            return await res.json()
        } else {
            throw new Error("No se encontro el empleado")
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
}


export async function editEmployee(formData) {
    formData.append('action', 'Update')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){    
            return await res.json()
        } else {
            const data = await res.json()
            throw new Error(data.message)
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
}


export async function deleteEmployee(formData) {
    formData.append('action', 'Delete')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){
            return await res.json()
        } else {
            throw new Error("No se pudo eliminar el empleado")
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
}

export async function getRolesForSelect() {
    let formData = new FormData();
    formData.append('action', 'GetRoles');

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
        
        return res.text()
    } catch (error) {
        console.log(error)
    }
}