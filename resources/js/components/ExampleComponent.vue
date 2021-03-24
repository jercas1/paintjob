<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Create Paint Job</div>

          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Plate Number</label>
              <input
                type="text"
                class="form-control"
                v-model="form.plate_number"
              />
            </div>

            <div class="mb-3">
              <label class="form-label">Current Color</label>
              <!-- <input
                type="text"
                class="form-control"
                v-model="form.current_color"
              /> -->
              <select class="form-select" aria-label="Default select example" v-model="form.current_color">
                <option selected value="">Current Color</option>
                <option value="Red">Red</option>
                <option value="Green">Green</option>
                <option value="Blue">Blue</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Target Color</label>
              <select class="form-select" aria-label="Default select example" v-model="form.target_color">
                <option selected value="">Current Color</option>
                <option value="Red">Red</option>
                <option value="Green">Green</option>
                <option value="Blue">Blue</option>
              </select>
            </div>

            <button
              type="submit"
              class="btn btn-primary mb-3"
              @click="create()"
            >
              Create Paint Job
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Paint Jobs in Progress</div>

          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Plate Number</th>
                  <th scope="col">Current Color</th>
                  <th scope="col">Target Color</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in paint_jobs.slice(0, 5)" :key="index">
                  <th scope="row">{{ item.plate_number }}</th>
                  <td>{{ item.current_color }}</td>
                  <td>{{ item.target_color }}</td>
                  <td><button
                    type="submit"
                    class="btn btn-primary mb-3"
                    @click="markCompleted(item.id)"
                  >
                    Mark as Completed
                  </button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Paint Queue</div>

          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Plate Number</th>
                  <th scope="col">Current Color</th>
                  <th scope="col">Target Color</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in paint_jobs.slice(5)" :key="index">
                  <th scope="row">{{ item.plate_number }}</th>
                  <td>{{ item.current_color }}</td>
                  <td>{{ item.target_color }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        plate_number: "",
        current_color: "",
        target_color: "",
      },

      paint_jobs: [],
    };
  },

  mounted() {
    this.get();
  },

  methods: {
    markCompleted(paint_job_id) {
      axios
        .get(`/api/paintjob-mark-completed/${paint_job_id}`)
        .then((res) => {
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    get() {
      axios
        .get("/api/paintjob-get")
        .then((res) => {
          console.log(res);
          this.paint_jobs = res.data.paint_jobs;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    create() {
      const formData = new FormData();
      for (const key in this.form) {
        formData.append(key, this.form[key]);
      }

      axios
        .post("/api/paintjob-create", formData)
        .then((res) => {
          console.log(res);
          if (res.data.success) {
            for (const key in this.form) {
              this.form[key] = "";
            }

            this.get();
            alert("Paint Job Created");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
