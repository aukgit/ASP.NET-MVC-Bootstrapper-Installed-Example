//------------------------------------------------------------------------------
// <auto-generated>
//    This code was generated from a template.
//
//    Manual changes to this file may cause unexpected behavior in your application.
//    Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace ReliSource.Models.EntityModel
{
    using System;
    using System.Collections.Generic;
    
    public partial class Shipper
    {
        public Shipper()
        {
            this.ProductOrders = new HashSet<ProductOrder>();
        }
    
        public int ShipperID { get; set; }
        public string CompanyName { get; set; }
        public string Phone { get; set; }
    
        public virtual ICollection<ProductOrder> ProductOrders { get; set; }
    }
}
