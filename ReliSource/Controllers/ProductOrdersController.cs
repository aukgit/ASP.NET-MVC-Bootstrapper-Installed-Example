﻿using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using DevTrends.MvcDonutCaching;
using ReliSource.Controllers;

using ReliSource.Models.EntityModel;

namespace ReliSource.Controllers
{
    public class ProductOrdersController : GenericController<NorthwindEntities> {

		#region Developer Comments - Alim Ul karim
        /*
         *  Generated by Alim Ul Karim on behalf of Developers Organism.
         *  Find us developers-organism.com
         *  https://fb.com/DevelopersOrganism
         *  mailto:alim@developers-organism.com	
         *  Google 'https://www.google.com.bd/search?q=Alim-ul-karim'
         *  First Written : 23 March 2014
         *  Modified      : 03 March 2015
         * * */
		#endregion

		#region Constants and variables

		const string DeletedError = "Sorry for the inconvenience, last record is not removed. Please be in touch with admin.";
		const string DeletedSaved = "Removed successfully.";
		const string EditedSaved = "Modified successfully.";
		const string EditedError = "Sorry for the inconvenience, transaction is failed to save into the database. Please be in touch with admin.";
		const string CreatedError = "Sorry for the inconvenience, couldn't create the last transaction record.";
		const string CreatedSaved = "Transaction is successfully added to the database.";
		const string ControllerName = "ProductOrders";
		///Constant value for where the controller is actually visible.
		const string ControllerVisibleUrl = "/ProductOrders/";
        const string CurrentControllerRemoveOutputCacheUrl = "/Partials/GetProductOrderID";
        const string DynamicLoadPartialController = "/Partials/";
        bool DropDownDynamic = true;
		#endregion

		#region Enums

		internal enum ViewStates {
            Index,
            Create,
            CreatePostBefore,
            CreatePostAfter,
            Edit,
            EditPostBefore,
            EditPostAfter,
            Details,
            Delete,
            DeletePost
        }

		#endregion

		#region Constructors
		
		public ProductOrdersController(): base(true){
			ViewBag.controller = ControllerName;
            ViewBag.visibleUrl = ControllerVisibleUrl;
            ViewBag.dropDownDynamic = DropDownDynamic;
            ViewBag.dynamicLoadPartialController = DynamicLoadPartialController;
		} 

		#endregion
		
		#region View tapping
		/// <summary>
        /// Always tap once before going into the view.
        /// </summary>
        /// <param name="view">Say the view state, where it is calling from.</param>
        /// <param name="productOrder">Gives the model if it is a editing state or creating posting state or when deleting.</param>
        /// <returns>If successfully saved returns true or else false.</returns>
		bool ViewTapping(ViewStates view, ProductOrder productOrder = null, bool entityValidState = true){
			switch (view){
				case ViewStates.Index:
					break;
				case ViewStates.Create:
					break;
				case ViewStates.CreatePostBefore: // before saving it
					break;
                case ViewStates.CreatePostAfter: // after saving
					break;
				case ViewStates.Edit:
					break;
				case ViewStates.Details:
					break;
				case ViewStates.EditPostBefore: // before saving it
					break;
                case ViewStates.EditPostAfter: // after saving
					break;
				case ViewStates.Delete:
					break;
			}
			return true;
		}
		#endregion

		#region Save database common method

		/// <summary>
        /// Better approach to save things into database(than db.SaveChanges()) for this controller.
        /// </summary>
        /// <param name="view">Say the view state, where it is calling from.</param>
        /// <param name="productOrder">Your model information to send in email to developer when failed to save.</param>
        /// <returns>If successfully saved returns true or else false.</returns>
		bool SaveDatabase(ViewStates view, ProductOrder productOrder = null){
			// working those at HttpPost time.
			switch (view){
				case ViewStates.Create:
					break;
				case ViewStates.Edit:
					break;
				case ViewStates.Delete:
					break;
			}

			try	{                
				var changes = db.SaveChanges(productOrder);
				if(changes > 0){
                    RemoveOutputCacheOnIndex();
                    RemoveOutputCache(CurrentControllerRemoveOutputCacheUrl);
					return true;
				}
			} catch (Exception ex){
				 throw new Exception("Message : " + ex.Message.ToString() + " Inner Message : " + ex.InnerException.Message.ToString());
			}
			return false;
		}
		#endregion

		#region DropDowns Generate



		public void GetDropDowns(ProductOrder productOrder = null){
			if(productOrder != null){
				ViewBag.CustomerID = new SelectList(db.Customers.ToList(), "CustomerID", "CompanyName", productOrder.CustomerID);
				ViewBag.EmployeeID = new SelectList(db.Employees.ToList(), "EmployeeID", "LastName", productOrder.EmployeeID);
				ViewBag.ShipVia = new SelectList(db.Shippers.ToList(), "ShipperID", "CompanyName", productOrder.ShipVia);
			} else {			
				ViewBag.CustomerID = new SelectList(db.Customers.ToList(), "CustomerID", "CompanyName");
				ViewBag.EmployeeID = new SelectList(db.Employees.ToList(), "EmployeeID", "LastName");
				ViewBag.ShipVia = new SelectList(db.Shippers.ToList(), "ShipperID", "CompanyName");
			}
			
		}

		public void GetDropDowns(System.Int32 id){			
				ViewBag.CustomerID = new SelectList(db.Customers.ToList(), "CustomerID", "CompanyName");
				ViewBag.EmployeeID = new SelectList(db.Employees.ToList(), "EmployeeID", "LastName");
				ViewBag.ShipVia = new SelectList(db.Shippers.ToList(), "ShipperID", "CompanyName");
		}
		#endregion

		#region Index
        [OutputCache(CacheProfile = "Year")]
        public ActionResult Index() { 
        
            var productOrders = db.ProductOrders.Include(p => p.Customer).Include(p => p.Employee).Include(p => p.Shipper);
			bool viewOf = ViewTapping(ViewStates.Index);
            return View(productOrders.ToList());
        }
		#endregion

		#region Index Find - Commented
		/*
        [OutputCache(CacheProfile = "Year")]
        public ActionResult Index(System.Int32 id) {
            var productOrders = db.ProductOrders.Include(p => p.Customer).Include(p => p.Employee).Include(p => p.Shipper).Where(n=> n. == id);
			bool viewOf = ViewTapping(ViewStates.Index);
            return View(productOrders.ToList());
        }
		*/
		#endregion

		#region Details
        public ActionResult Details(System.Int32 id) {
        
            if (id == null) {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            var productOrder = db.ProductOrders.Find(id);
            if (productOrder == null)
            {
                return HttpNotFound();
            }
			bool viewOf = ViewTapping(ViewStates.Details, productOrder);
            return View(productOrder);
        }
		#endregion

		#region Create or Add
        public ActionResult Create() {        
			if(DropDownDynamic == false){
                GetDropDowns();
            }
			bool viewOf = ViewTapping(ViewStates.Create);
            return View();
        }

		/*
		public ActionResult Create(System.Int32 id) {        
			if(DropDownDynamic == false){
                GetDropDowns(id);// Generate hidden.
            }
			bool viewOf = ViewTapping(ViewStates.Create);
            return View();
        }
		*/

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create(ProductOrder productOrder) {
			bool viewOf = ViewTapping(ViewStates.CreatePostBefore, productOrder);
			if(DropDownDynamic == false){
                GetDropDowns(productOrder);
            }
            if (ModelState.IsValid) {            
                db.ProductOrders.Add(productOrder);
                bool state = SaveDatabase(ViewStates.Create, productOrder);
				if (state) {			
					AppVar.SetSavedStatus(ViewBag, CreatedSaved); // Saved Successfully.
				} else {					
					AppVar.SetErrorStatus(ViewBag, CreatedError); // Failed to save
				}
				
                viewOf = ViewTapping(ViewStates.CreatePostAfter, productOrder,state);
                return View(productOrder);
            }
            viewOf = ViewTapping(ViewStates.CreatePostAfter, productOrder, false);			
			AppVar.SetErrorStatus(ViewBag, CreatedError); // record is not valid for creation
            return View(productOrder);
        }
		#endregion

        #region Edit or modify record
        public ActionResult Edit(System.Int32 id) {
        
            if (id == null) {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            var productOrder = db.ProductOrders.Find(id);
            if (productOrder == null)
            {
                return HttpNotFound();
            }
			bool viewOf = ViewTapping(ViewStates.Edit, productOrder);
			if(DropDownDynamic == false){
                GetDropDowns(productOrder); // Generating drop downs
            }
            return View(productOrder);
        }

        
        
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit(ProductOrder productOrder) {
			bool viewOf = ViewTapping(ViewStates.EditPostBefore, productOrder);
            if (ModelState.IsValid)
            {
                db.Entry(productOrder).State = EntityState.Modified;
                bool state = SaveDatabase(ViewStates.Edit, productOrder);
				if (state) {
                    AppVar.SetSavedStatus(ViewBag, EditedSaved); // Saved Successfully.
				} else {					
					AppVar.SetErrorStatus(ViewBag, EditedError); // Failed to Save
				}
				
                viewOf = ViewTapping(ViewStates.EditPostAfter, productOrder , state);
                return RedirectToAction("Index");
            }
            viewOf = ViewTapping(ViewStates.EditPostAfter, productOrder , false);
        	if(DropDownDynamic == false){
                GetDropDowns(productOrder); // Generating drop downs
            }
            AppVar.SetErrorStatus(ViewBag, EditedError); // record not valid for save
            return View(productOrder);
        }
		#endregion

		#region Delete or remove record

		
        public ActionResult Delete(int id) {
        
            var productOrder = db.ProductOrders.Find(id);
            bool viewOf = ViewTapping(ViewStates.Delete, productOrder);
			return View(productOrder);
        }

        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]		
        public ActionResult DeleteConfirmed(int id) {
            var productOrder = db.ProductOrders.Find(id);
			bool viewOf = ViewTapping(ViewStates.DeletePost, productOrder);
            db.ProductOrders.Remove(productOrder);
            bool state = SaveDatabase(ViewStates.Delete, productOrder);
			if (!state) {			
				AppVar.SetErrorStatus(ViewBag, DeletedError); // Failed to Save				
                return View(productOrder);
			}
			
            return RedirectToAction("Index");
        }
		#endregion

		#region Removing output cache
		public void RemoveOutputCache(string url) {
			HttpResponse.RemoveOutputCacheItem(url);
		}
        
        public void RemoveOutputCacheOnIndex() {
            var cacheManager = new OutputCacheManager();
            cacheManager.RemoveItems(ControllerName, "Index");
            cacheManager.RemoveItems(ControllerName, "List");
            cacheManager = null;
            GC.Collect();
        }
		#endregion
    }

	
}
