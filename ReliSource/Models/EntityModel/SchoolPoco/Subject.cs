//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace ReliSource.Models.EntityModel
{
    using System;
    using System.Collections.Generic;
    
    public partial class Subject
    {
        public int SubjectID { get; set; }
        public string SubjectName { get; set; }
        public int SchoolClassID { get; set; }
    
        public virtual SchoolClass SchoolClass { get; set; }
    }
}
