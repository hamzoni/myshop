<div class="wrapper_left">
	<div class="wrp_ccTc">
		<div id="page_view_CC" class="chart_container"></div>
		<form name="PAGEVIEW_pgView" d_type="VIEWS">
			<div class="toolbar">
				<div class="lbl_wrap">
					
					<span class="chsLck">display overall</span>
					<span class="chsLck">display year</span>
					<span class="chsLck">display month</span>
					<span class="chsLckT">year</span>
					<span class="chsLckT">month</span>
		
				</div>
				<div class="inp_wrap">
					<div class="sAvgRw">
						<input class="_scTbB" type="button" name="sum_overall" value="SUM"></input>
						<input class="_scTbB" type="button" name="avg_overall" value="AVG"></input>
					</div>
					<div class="sAvgRw">
						<input class="_scTbB" type="button" name="sum_year" value="SUM"></input>
						<input class="_scTbB" type="button" name="avg_year" value="AVG"></input>
					</div>
					<div class="sAvgRw">
						<input class="_scTbBF" type="button" name="sum_month" value="SUM"></input>
					</div>
					<select class="chse_obj" name="_chooseYear"></select>
					<select class="chse_obj" name="_chooseMonth"></select>
				</div>
			</div>
		</form>
		<!-- end of PAGEVIEW_pgView -->
		<div class="summary_field" id="VIEWS">
			<div class="group_DtF" type="THIS_YEAR_TOTAL">
				<div class="_tblS_lbl">Total {TYPE} in year {YEAR}:</div>
				<span class="_valHmAt">{YEAR_SUM}</span>
			</div>
			<div class="group_DtF" type="THIS_MONTH_TOTAL">
				<div class="_tblS_lbl">Total {TYPE} in month {MONTH} {YEAR}:</div>
				<span class="_valHmAt">{MONTH_SUM}</span>
			</div>
			<div class="group_DtF" type="THIS_TODAY_TOTAL">
				<div class="_tblS_lbl">Total {TYPE} today {DAY} {MONTH} {YEAR}:</div>
				<span class="_valHmAt">{TODAY_SUM}</span>
			</div>

			<div class="group_DtF" type="MAX_YEAR_ALL">
				<div class="_tblS_lbl">Highest Year of all time :</div>
				<span class="_valHmAt">{MAX_YEAR_ALL}</span>
			</div>

			<div class="group_DtF" type="MAX_MONTH_ALL">
				<div class="_tblS_lbl">Highest Month of all time:</div>
				<span class="_valHmAt">{MAX_MONTH_ALL}</span>
			</div>

			<div class="group_DtF" type="MAX_DAY_ALL">
				<div class="_tblS_lbl">Highest Day of all time:</div>
				<span class="_valHmAt">{MAX_DATE_ALL}</span>
			</div>

			<div class="group_DtF" type="SUM_ALL_TIME">
				<div class="_tblS_lbl">Total {TYPE} since beginning :</div>
				<span class="_valHmAt">{SUM_ALL}</span>
			</div>

			<div class="group_DtF" type="AVG_ALL_TIME">
				<div class="_tblS_lbl">Average {TYPE} since beginning:</div>
				<span class="_valHmAt">{AVERAGE_ALL}</span>
			</div>

			<div class="_tblS_lbl tbl_lbl_hl">Highest month of all years...</div>
			<div class="tbl_ctNer">
				<table border="1" term="MAX_MONTH_OF_YEAR"></table>
			</div>
			
			<div class="_tblS_lbl tbl_lbl_hl">Lowest month of all years...</div>
			<div class="tbl_ctNer">
				<table border="1" term="MIN_MONTH_OF_YEAR"></table>
			</div>		
		</div>
	</div>
	<div class="wrp_ccTc">
		<div id="account_CC" class="chart_container"></div>
		<form name="ACCOUNTS_pgView" d_type="ACCOUNTS">
			<div class="toolbar">
				<div class="lbl_wrap">
					
					<span class="chsLck">display overall</span>
					<span class="chsLck">display year</span>
					<span class="chsLck">display month</span>
					<span class="chsLckT">year</span>
					<span class="chsLckT">month</span>
		
				</div>
				<div class="inp_wrap">
					<div class="sAvgRw">
						<input class="_scTbB" type="button" name="sum_overall" value="SUM"></input>
						<input class="_scTbB" type="button" name="avg_overall" value="AVG"></input>
					</div>
					<div class="sAvgRw">
						<input class="_scTbB" type="button" name="sum_year" value="SUM"></input>
						<input class="_scTbB" type="button" name="avg_year" value="AVG"></input>
					</div>
					<div class="sAvgRw">
						<input class="_scTbBF" type="button" name="sum_month" value="SUM"></input>
					</div>
					<select class="chse_obj" name="_chooseYear"></select>
					<select class="chse_obj" name="_chooseMonth"></select>
				</div>
			</div>
		</form>
		<!-- end of ACCOUNTS_pgView -->
		<div class="summary_field" id="ACCOUNTS"></div>
	</div>
</div>
<!-- end of wrapper_left -->
<div class="wrapper_right">
	<div class="wrp_ccTc">
		<div id="transaction_CC" class="chart_container"></div>
		<form name="TRANSACTION_pgView" d_type="TRANSACTIONS">
			<div class="toolbar">
				<div class="lbl_wrap">
					
					<span class="chsLck">display overall</span>
					<span class="chsLck">display year</span>
					<span class="chsLck">display month</span>
					<span class="chsLckT">year</span>
					<span class="chsLckT">month</span>
		
				</div>
				<div class="inp_wrap">
					<div class="sAvgRw">
						<input class="_scTbB" type="button" name="sum_overall" value="SUM"></input>
						<input class="_scTbB" type="button" name="avg_overall" value="AVG"></input>
					</div>
					<div class="sAvgRw">
						<input class="_scTbB" type="button" name="sum_year" value="SUM"></input>
						<input class="_scTbB" type="button" name="avg_year" value="AVG"></input>
					</div>
					<div class="sAvgRw">
						<input class="_scTbBF" type="button" name="sum_month" value="SUM"></input>
					</div>
					<select class="chse_obj" name="_chooseYear"></select>
					<select class="chse_obj" name="_chooseMonth"></select>
				</div>
			</div>
		</form>
		<!-- end of TRANSACTION_pgView -->
		<div class="summary_field" id="TRANSACTIONS"></div>
	</div>
	<div class="wrp_ccTc">
		<div id="income_CC" class="chart_container"></div>
		<form name="INCOME_pgView" d_type="INCOMES">
			<div class="toolbar">
				<div class="lbl_wrap">
					
					<span class="chsLck">display overall</span>
					<span class="chsLck">display year</span>
					<span class="chsLck">display month</span>
					<span class="chsLckT">year</span>
					<span class="chsLckT">month</span>
		
				</div>
				<div class="inp_wrap">
					<div class="sAvgRw">
						<input class="_scTbB" type="button" name="sum_overall" value="SUM"></input>
						<input class="_scTbB" type="button" name="avg_overall" value="AVG"></input>
					</div>
					<div class="sAvgRw">
						<input class="_scTbB" type="button" name="sum_year" value="SUM"></input>
						<input class="_scTbB" type="button" name="avg_year" value="AVG"></input>
					</div>
					<div class="sAvgRw">
						<input class="_scTbBF" type="button" name="sum_month" value="SUM"></input>
					</div>
					<select class="chse_obj" name="_chooseYear"></select>
					<select class="chse_obj" name="_chooseMonth"></select>
				</div>
			</div>
		</form>
		<!-- end of INCOME_pgView -->
		<div class="summary_field" id="INCOMES"></div>
	</div>
</div>
<!-- end of wrapper_right -->
<script type="text/javascript">
	function set_preset() {
		this.base_url = '<?=$data["base_url"]?>';
		this.base_stats = '<?=$data["stats"]?>';
	}
</script>