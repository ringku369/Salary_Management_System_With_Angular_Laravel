<?php 
  

  // Deposit crud area

  createDeposit(request:any): any{
    return this.http.post(`${this.baseurl.geturl()}/admin/createDeposit`,request);
  }
  getDeposit(): any{
    return this.http.get(`${this.baseurl.geturl()}/admin/getDeposit`);
  }

  updateDeposit(request:any): any{
    return this.http.put(`${this.baseurl.geturl()}/admin/updateDeposit`,request);
  }

  deleteDeposit(id:any): any{
    return this.http.delete(`${this.baseurl.geturl()}/admin/deleteDeposit/${id}`);
  }

  // Deposit crud area

