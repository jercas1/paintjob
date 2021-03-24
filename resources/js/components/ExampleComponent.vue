<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-12 mb-5">
        <div class="row">
          <div class="col-auto">
            <img :src="changeCurrentColor()" class="img-fluid" alt="...">
          </div>

          <div class="col-auto">
            ->
          </div>

          <div class="col-auto">
            <img :src="changeTargetColor()" class="img-fluid" alt="...">
          </div>
        </div>
      </div>

      <div class="col-md-12">
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
              <select
                class="form-select"
                aria-label="Default select example"
                v-model="form.current_color"
              >
                <option selected value="">Current Color</option>
                <option value="Red">Red</option>
                <option value="Green">Green</option>
                <option value="Blue">Blue</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Target Color</label>
              <select
                class="form-select"
                aria-label="Default select example"
                v-model="form.target_color"
              >
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


    <div class="row">
      <div class="col-8">
        <div class="row justify-content-center mt-5">
          <div class="col-md-12">
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
                    <tr
                      v-for="(item, index) in paint_jobs.slice(0, 5)"
                      :key="index"
                    >
                      <th scope="row">{{ item.plate_number }}</th>
                      <td>{{ item.current_color }}</td>
                      <td>{{ item.target_color }}</td>
                      <td>
                        <button
                          type="submit"
                          class="btn btn-primary mb-3"
                          @click="markCompleted(item.id, index)"
                        >
                          Mark as Completed
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row justify-content-center mt-5">
          <div class="col-md-12">
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

    <div class="col-4">
      <div class="row justify-content-center mt-5" v-if="breakdown.length">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">SHOP PERFORMANCE</div>

            <div class="card-body">
              <dl class="row">
                <dt class="col-sm-3">Total Cars Painted:</dt>
                <dd class="col-sm-9">
                  {{ breakdown.map(e => e.breakdown).reduce((a, b) => a + b, 0) }}
                </dd>

                <dt class="col-sm-12">Breakdown:</dt>

                <dt class="col-sm-3" style="padding-left: 30px">Blue</dt>
                <dd class="col-sm-9">
                  {{ breakdown.find(e => e.target_color == 'Blue').breakdown }}
                </dd>

                <dt class="col-sm-3" style="padding-left: 30px">Red</dt>
                <dd class="col-sm-9">
                  {{ breakdown.find(e => e.target_color == 'Red').breakdown }}
                </dd>

                <dt class="col-sm-3" style="padding-left: 30px">Green</dt>
                <dd class="col-sm-9">
                  {{ breakdown.find(e => e.target_color == 'Green').breakdown }}
                </dd>
              </dl>
            </div>
          </div>
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

      breakdown: [],
    };
  },

  mounted() {
    this.get();
    this.getBreakDown();
  },

  methods: {
    changeCurrentColor() {
      console.log('change')
      if (this.form.current_color == '') {
        return '/assets/Default Car.png'
      } else if (this.form.current_color == 'Red') {
        return '/assets/Red Car.png'
      } else if (this.form.current_color == 'Green') {
        return '/assets/Green Car.png'
      } else if (this.form.current_color == 'Blue') {
        return '/assets/Blue Car.png'
      }
    },

    changeTargetColor() {
      console.log('change')
      if (this.form.target_color == '') {
        return '/assets/Default Car.png'
      } else if (this.form.target_color == 'Red') {
        return '/assets/Red Car.png'
      } else if (this.form.target_color == 'Green') {
        return '/assets/Green Car.png'
      } else if (this.form.target_color == 'Blue') {
        return '/assets/Blue Car.png'
      }
    },

    getBreakDown() {
      axios
        .get("/api/paintjob-get-breakdown")
        .then((res) => {
          this.breakdown = res.data.breakdown;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    markCompleted(paint_job_id, index) {
      axios
        .get(`/api/paintjob-mark-completed/${paint_job_id}`)
        .then((res) => {
          if (res.data.success) {
            this.paint_jobs.splice(index, 1);
            alert("Paint Job Mark as Completed");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },

    get() {
      axios
        .get("/api/paintjob-get")
        .then((res) => {
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
          if (res.data.success) {
            for (const key in this.form) {
              this.form[key] = "";
            }

            this.paint_jobs.push(res.data.paint_job);
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
