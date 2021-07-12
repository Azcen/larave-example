// import Vue from "vue";
// import axios from "axios";
// import app from "../main";
// import { paramCase, camelCase, snakeCase } from "change-case";
// import pluralize from "pluralize";

export default class {
  constructor() {
    // let camelCaseModel = camelCase(module);
    // let snakeCaseModel = snakeCase(module);
    // let camelCaseModelSingular = pluralize.singular(camelCaseModel);
    // let paramCaseModel = paramCase(module);
    this.state = {
      pagination: {
        currentPage: 1,
        perPage: 5,
        totalUsers: 0,
        totalPages: 0
      }
    }

    this.mutations = {}

    this.actions = {}

    this.getters = {
      pagination: (state) => state.pagination
    }
  }
}
