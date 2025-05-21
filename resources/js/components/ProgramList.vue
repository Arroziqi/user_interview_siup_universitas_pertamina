<template>
    <div>
        <h1>Daftar Program Studi</h1>
        <button @click="openCreateModal" class="btn btn-primary mb-3">
            Tambah Program Baru
        </button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Program</th>
                    <th>Singkatan</th>
                    <th>Fakultas</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="programs.length === 0">
                    <td colspan="5" class="text-center">
                        Tidak ada data program.
                    </td>
                </tr>
                <tr v-for="program in programs" :key="program.id">
                    <td>{{ program.code }}</td>
                    <td>{{ program.name }}</td>
                    <td>{{ program.short_name }}</td>
                    <td>{{ program.faculty?.name || "-" }}</td>
                    <td>
                        <button
                            @click="openEditModal(program)"
                            class="btn btn-sm btn-warning"
                        >
                            Edit
                        </button>
                        <button
                            @click="deleteProgram(program.id)"
                            class="btn btn-sm btn-danger"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal for Create / Edit -->
        <div v-if="showModal" class="modal-overlay">
            <div class="modal-content">
                <h3>
                    {{ isEditMode ? "Edit Program" : "Tambah Program Baru" }}
                </h3>
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label for="code">Kode</label>
                        <input
                            type="text"
                            id="code"
                            v-model="form.code"
                            required
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Program</label>
                        <input
                            type="text"
                            id="name"
                            v-model="form.name"
                            required
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label for="short_name">Singkatan</label>
                        <input
                            type="text"
                            id="short_name"
                            v-model="form.short_name"
                            required
                            class="form-control"
                        />
                    </div>

                    <div class="form-group">
                        <label for="faculty">Fakultas</label>
                        <select
                            id="faculty"
                            v-model="form.faculty_id"
                            required
                            class="form-control"
                        >
                            <option value="" disabled>
                                -- Pilih Fakultas --
                            </option>
                            <option
                                v-for="faculty in faculties"
                                :key="faculty.id"
                                :value="faculty.id"
                            >
                                {{ faculty.name }}
                            </option>
                        </select>
                    </div>

                    <div class="modal-actions">
                        <button type="submit" class="btn btn-success">
                            {{ isEditMode ? "Update" : "Tambah" }}
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="closeModal"
                        >
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            programs: [],
            faculties: [],
            showModal: false,
            isEditMode: false,
            form: {
                id: null,
                code: "",
                name: "",
                short_name: "",
                faculty_id: "",
            },
        };
    },
    mounted() {
        this.fetchPrograms();
        this.fetchFaculties();
    },
    methods: {
        fetchPrograms() {
            fetch("/api/programs")
                .then((res) => res.json())
                .then((data) => {
                    this.programs = data;
                })
                .catch(() => {
                    this.programs = [];
                });
        },
        fetchFaculties() {
            fetch("/api/faculties")
                .then((res) => res.json())
                .then((data) => {
                    this.faculties = data;
                })
                .catch(() => {
                    this.faculties = [];
                });
        },
        openCreateModal() {
            this.isEditMode = false;
            this.resetForm();
            this.showModal = true;
        },
        openEditModal(program) {
            this.isEditMode = true;
            this.form.id = program.id;
            this.form.code = program.code;
            this.form.name = program.name;
            this.form.short_name = program.short_name;
            this.form.faculty_id = program.faculty?.id || "";
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.resetForm();
        },
        resetForm() {
            this.form = {
                id: null,
                code: "",
                name: "",
                short_name: "",
                faculty_id: "",
            };
        },
        submitForm() {
            const url = this.isEditMode
                ? `/api/programs/${this.form.id}`
                : "/api/programs";
            const method = this.isEditMode ? "PUT" : "POST";

            fetch(url, {
                method,
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    code: this.form.code,
                    name: this.form.name,
                    short_name: this.form.short_name,
                    faculty_id: this.form.faculty_id,
                }),
            })
                .then((res) => {
                    if (!res.ok) throw new Error("Gagal menyimpan data");
                    return res.json();
                })
                .then((savedProgram) => {
                    if (this.isEditMode) {
                        // Update data lokal
                        const index = this.programs.findIndex(
                            (p) => p.id === savedProgram.id
                        );
                        if (index !== -1)
                            this.programs.splice(index, 1, savedProgram);
                    } else {
                        // Tambah data lokal
                        this.programs.push(savedProgram);
                    }
                    this.closeModal();
                })
                .catch((err) => {
                    alert(
                        err.message || "Terjadi kesalahan saat menyimpan data"
                    );
                });
        },
        deleteProgram(id) {
            if (!confirm("Apakah Anda yakin ingin menghapus program ini?"))
                return;

            fetch(`/api/programs/${id}`, { method: "DELETE" })
                .then((res) => {
                    if (res.ok) {
                        this.programs = this.programs.filter(
                            (p) => p.id !== id
                        );
                    } else {
                        alert("Gagal menghapus program");
                    }
                })
                .catch(() => {
                    alert("Terjadi kesalahan saat menghapus program");
                });
        },
    },
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal-content {
    background: white;
    padding: 20px;
    border-radius: 6px;
    width: 400px;
}
.form-group {
    margin-bottom: 1rem;
}
.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
</style>
