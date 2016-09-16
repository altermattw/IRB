<?php
	
	
?>


<div id="expeditedCategories">
	<div class="panel panel-default"> <!-- classified research -->
		<div class="panel-body">		
			<label>
				4.1. Is your research &ldquo;classified&rdquo;? In other words, is knowledge of either the procedures or results of your research restricted to individuals with United States government security clearances?
			</label>
			<div>
				<label class="radio-inline">
					<input type="radio" class="fullReview" name="classified" value="1">Yes.
				</label>					
				<!-- classified research is ineligible for expedited review -->
				<label class="radio-inline">
					<input type="radio" name="classified" value="0">No.
				</label>
			</div>			
		</div>
	</div>
	<div class="panel panel-default"> <!-- drugs -->	
		<div class="panel-body">			
			<label>
				4.2. Does the study involve the use of drugs that you provide to research participants?
			</label>
			<div>
				<label class="radio-inline">
					<input type="radio" class="expand" data-expand="yes" name="drugStudy" value="1">Yes.
				</label>					
				<div class="panel panel-default drugStudy" id="drugStudy1" hidden>					
					<div class="panel-body">	<!-- new indication -->								
						<label>
							4.2.1. Do you intend to report the results of your study to the FDA as a well-controlled study in support of a new indication for use?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" class="fullReview" name="newIndication" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="newIndication" value="0">No.
							</label>
						</div>						
					</div>				
					<div class="panel-body"> <!-- change in labeling -->
						<label>
							4.2.2. Do you intend for your results to be used to support any other significant change in the labeling for the drug?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" class="fullReview" name="labelChange" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="labelChange" value="0">No.
							</label>
						</div>						
					</div>
					<div class="panel-body"> <!-- change in advertising -->
						<label>
							4.2.3. Do you intend for your results to support a significant change in the advertising for a drug that is lawfully marketed as a prescription drug product?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" class="fullReview" name="changeAdvertising" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="changeAdvertising" value="0">No.
							</label>
						</div>						
					</div>					
					<div class="panel-body"> <!-- route / dosage -->
						<label>
							4.2.4. Does your procedure involve a route of administration or dosage level or use in a patient population or other factor that significantly increases the risks (or decreases the acceptability of the risks) associated with the use of the drug product?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" class="fullReview" name="drugIncreaseRisk" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="drugIncreaseRisk" value="0">No.
							</label>
						</div>						
					</div>
					<div class="panel-body"> <!-- compliance with informed consent? -->
						<label>
							4.2.5. Is your procedure in compliance with the requirements for informed consent?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="drugInfConsent" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" class="fullReview" name="drugInfConsent" value="0">No.
							</label>
						</div>						
					</div>
					<div class="panel-body">
						<label>
							4.2.6. Do you promise not to promote the drug under investigation as safe or effective? <a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=312.7" target="_blank">(§ 312.7(a))</a>
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="drugNoPromote" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" class="fullReview" name="drugNoPromote" value="0">No.
							</label>
						</div>				
					</div>
					<div class="panel-body">
						<label>
							4.2.7. Do you promise not to commercially distribute or test market an investigational new drug? <a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=312.7" target="_blank">(§ 312.7(a))</a>
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="drugNoDistribute" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" class="fullReview" name="drugNoDistribute" value="0">No.
							</label>
						</div>				
					</div>
					<div class="panel-body">
						<label>
							4.2.8. Do you promise not to unduly prolong an investigation after finding that the results of the investigation appear to establish sufficient data to support a marketing application? <a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=312.7" target="_blank">(§ 312.7(a))</a>
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="drugNoProlong" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" class="fullReview" name="drugNoProlong" value="0">No.
							</label>
						</div>				
					</div>
				</div>
				<label class="radio-inline">
					<input type="radio" class="expand" data-expand="no" name="drugStudy" value="0">No.
				</label>
			</div>						
		</div>
	</div>
	<div class="panel panel-default"> <!-- medical devices -->
		<div class="panel-body">
			<label>
				 4.3. Does the study involve medical devices?
			</label>
			<div>
				<label class="radio-inline">
					<input type="radio" class="expand" name="devicesStudy" value="1">Yes.
				</label>
				<div class="panel panel-default devicesStudy" id="devicesStudy1" hidden>			
					<div class="panel-body"> <!-- significant risk device -->
						<label>
							 4.3.1. Does the device present a potential for serious risk to the health, safety, or welfare of a subject? [<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfCFR/CFRSearch.cfm?fr=812.3" target="_blank">21CFR812.3(m)</a>]
						</label>	
						<!-- this by itself would disqualify the study from expedited review -->				
						<div>
							<label class="radio-inline">
								<input type="radio" class="fullReview" data-text='You will need to submit an &ldquo;Investigational Device Exemption&rdquo; application to the FDA [<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfCFR/CFRSearch.cfm?CFRPart=812&showFR=1&subpartNode=21:8.0.1.1.9.2" target="_blank">see 21 CFR 812.20</a>] and receive approval prior to beginning research. ' name="deviceRisk" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="deviceRisk" value="0">No.
							</label>
						</div>					
					</div>				
					<div class="panel-body"> <!-- approved for marketing -->
						<label>
							4.3.2. Has the device been approved for marketing and used in accordance with its cleared/approved labeling? [<a href="http://www.hhs.gov/ohrp/policy/63fr60364.html" target="_blank">63FR60364, F(1)(b)(ii)</a>]
						</label>	
						<!-- so long as it's not a significant risk device, the above would qualify the study as expedited -->
						<div>
							<label class="radio-inline">
								<input type="radio" name="deviceApproved" value="1">Yes.
							</label>	
							<div class="panel panel-default deviceApproved" id="deviceApproved1" hidden>
								<div class="panel-body">
									<label>
										4.3.2.1. Provide evidence that the device has been approved for marketing and is being used in accordance with its cleared/approved labeling.
									</label>
									<div>
										<textarea name="deviceApprovedExp" class="form-control" rows="5"></textarea>	
									</div>
								</div>
							</div>				
							<label class="radio-inline">
								<input type="radio" name="deviceApproved" value="0">No.
							</label>
						</div>					
					</div>
				<!-- an investigational device exemption application (21 CFR Part 812) is not required -->
				<div class="panel-body"> <!-- diagnostic device -->
					<label>
						4.3.3. Is the device intended for use in the collection, preparation, and examination of specimens taken from the human body for the purpose of diagnosing disease or other conditions (i.e., is it an &ldquo;in vitro diagnostic&rdquo;) [<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=809.3" target="_blank">21CFR809.3(a)</a>]?
					</label>
					<div>
						<label class="radio-inline">
							<input type="radio" class="expand" data-expand="yes" name="deviceInVitro" value="1">Yes.
						</label>
						<div class="panel panel-default deviceInVitro" id="deviceInVitro1"> <!-- diagnostic div -->
							<div class="panel-body"> <!-- shipments or deliveries from sponsor -->
								<label>
									4.3.3.1. Do you promise to ensure that all shipments or deliveries of the device are prominently labeled &ldquo;For Research Use Only. Not for use in diagnostic procedures.&rdquo; in the case of devices in the laboratory research phase, or &ldquo;For Investigational Use Only. The performance characteristics of this product have not been established.&rdquo; in the case of devices being product-tested prior to full commercial marketing? [<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=812.2" target="_blank">21CFR812.2(c)(3)</a>, <a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=809.10">21CFR809.10(c)(2)</a>]
								</label>
								<div>
									<label class="radio-inline">
										<input type="radio" name="shipments" value="1">Yes.
									</label>					
									<label class="radio-inline">
										<input type="radio" name="shipments" value="0">No.
									</label>
								</div>
							</div>
							<div class="panel-body"> <!-- noninvasive -->
								<label>
									4.3.3.2. Is the device testing <em>noninvasive</em>? (Noninvasive means that the device does not, by design or intention, penetrate or pierce the skin or mucous membranes of the body, the ocular cavity, or the urethra; or enter the ear beyond the external auditory canal, the nose beyond the nares, the mouth beyond the pharynx, the anal canal beyond the rectum, or the vagina beyond the cervical os. For purposes of this part, blood sampling that involves simple venipuncture is considered noninvasive, and the use of surplus samples of body fluids or tissues that are left over from samples taken for noninvestigational purposes is also considered noninvasive.) [<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=812.2" target="_blank">21CFR812(c)(3)(i)</a>]
								</label>
								<div>
									<label class="radio-inline">
										<input type="radio" class="expedited" data-expedited="null" name="deviceNonInvasive" value="1">Yes.
									</label>					
									<label class="radio-inline">
										<input type="radio" class="expedited" data-expedited="no" name="deviceNonInvasive" value="0">No.
									</label>
								</div>
							</div>						
							<div class="panel-body"> <!-- energy -->
								<label>
									4.3.3.3. Does the device testing, by design or intention, introduce energy into a subject? [<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=812.2" target="_blank">21CFR812(c)(3)(iii)</a>]
								</label>
								<div>
									<label class="radio-inline">
										<input type="radio" class="expedited" data-expedited="no" name="deviceEnergy" value="1">Yes.
									</label>					
									<label class="radio-inline">
										<input type="radio" class="expedited" data-expedited="null" name="deviceEnergy" value="0">No.
									</label>
								</div>															
							</div>
							<div class="panel-body"> <!-- confirm diagnosis -->
								<label>
									4.3.3.4. Will device testing be used as a diagnostic procedure without confirmation of the diagnosis by another, medically established diagnostic product or procedure? [<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=812.2" target="_blank">21CFR812(c)(3)(iv)</a>]
								</label>
								<div>
									<label class="radio-inline">
										<input type="radio" class="expedited" data-expedited="no" name="deviceDiagnose" value="1">Yes.
									</label>					
									<label class="radio-inline">
										<input type="radio" class="expedited" data-expedited="null" name="deviceDiagnose" value="0">No.
									</label>
								</div>								
							</div>
						</div>					
						<label class="radio-inline">
							<input type="radio" class="expand" data-expand="no" name="deviceInVitro" value="0">No.
						</label>
					</div>	
				</div>				
				<div class="panel-body"> <!-- consumer pref testing -->						
					<label>
						4.3.4. Is the device undergoing consumer preference testing, testing of a modification, or testing of a combination of two or more devices in commercial distribution? [<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=812.2" target="_blank">21CFR812(c)(4)</a>]
						<!-- this grants expedited so long as no risk and not for purpose of determining safety or effectiveness -->
					</label>
					<div>
						<label class="radio-inline">
							<input type="radio" class="expedited" data-expedited="yes" name="devicePreference" value="1">Yes.
						</label>					
						<label class="radio-inline">
							<input type="radio" class="expedited" data-expedited="null" name="devicePreference" value="0">No.
						</label>
					</div>
				</div>								
				<div class="panel-body"><!-- custom device -->	
					<label>
						4.3.5. Is the device a &ldquo;custom device&rdquo;?  According to <a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfCFR/CFRSearch.cfm?fr=812.3" target="_blank">21CFR812.3(b)</a>, a custom device is a device that:
						<ul class="list-unstyled">
							<li>(1) Necessarily deviates from devices generally available or from an applicable performance standard or premarket approval requirement in order to comply with the order of an individual physician or dentist;</li>
							<li>(2) Is not generally available to, or generally used by, other physicians or dentists;</li>
							<li>(3) Is not generally available in finished form for purchase or for dispensing upon prescription;</li>
							<li>(4) Is not offered for commercial distribution through labeling or advertising; and</li>
							<li>(5) Is intended for use by an individual patient named in the order of a physician or dentist, and is to be made in a specific form for that patient, or is intended to meet the special needs of the physician or dentist in the course of professional practice.</li>
						</ul>
						[<a href="http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfcfr/CFRSearch.cfm?fr=812.2" target="_blank">21CFR812(c)(4)</a>]
						<!-- this grants expedited so long as no risk and not for purpose of determining safety or effectiveness -->
					</label>
					<div>
						<label class="radio-inline">
							<input type="radio" class="expand" name="deviceCustom" value="1">Yes.
						</label>
						<div class="panel panel-default deviceCustom" id="deviceCustom1" hidden>
							<div class="panel-body">
								<label>
									4.3.5.1. Is the device being used to determine the safety or effectiveness of the device for commercial distribution?
								</label>
								<div>
									<label class="radio-inline">
										<input type="radio" class="expedited" data-expedited="no" name="safetyEffectiveness" value="1">Yes.
									</label>					
									<label class="radio-inline">
										<input type="radio" class="expedited" data-expedited="yes" name="safetyEffectiveness" value="0">No.
									</label>
								</div>
							</div>
						</div>			
						<label class="radio-inline">
							<input type="radio" class="expand" name="deviceCustom" value="0">No.
						</label>
					</div>					
				</div>						
				
			</div>					
				<label class="radio-inline">
					<input type="radio" class="expand" name="devicesStudy" value="0">No.
				</label>
			</div>
			
		</div>
	</div>
	<div class="panel panel-default"> <!-- blood samples -->
		<div class="panel-body">
			<label>
				4.4. Does your study involve the collection of blood samples by finger stick, heel stick, ear stick, or venipuncture?
			</label>
			<div>
				<label class="radio-inline">
					<input type="radio" name="blood" class="expand" data-expand="yes" value="1">Yes.
				</label>
				<div class="panel panel-default blood" id="blood1" hidden>
					<div class="panel-body">
						<label>
							4.4.1. Has the person performing the collection met all state and federal training and licensing requirements for the type of blood collection he or she will perform?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="bloodLicense" class="expedited" data-expedited="null" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="bloodLicense" class="expedited" data-expedited="no" value="0">No.
							</label>
						</div>
					</div>
					<div class="panel-body">
						<label>
							4.4.2. Will all of your participants be healthy, nonpregnant adults who weigh at least 110 pounds?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="bloodParticipants" class="blood1" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="bloodParticipants" class="blood1" value="0">No.
							</label>
						</div>
					</div>
					<div class="panel-body">
						<label>
							4.4.3. Will the amount drawn be less than 550 ml in an 8 week period and collected no more frequently than 2 times per week?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="blood550ml" class="blood1" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="blood550ml" class="blood1" value="0">No.
							</label>
						</div>
					</div>
					<div class="panel-body blood2" hidden>
						<label>
							4.4.4. Will the the amount drawn be less than 3 ml per kg of body weight in an 8 week period?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="blood3ml" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="blood3ml" value="0">No.
							</label>
						</div>
					</div>
					<div class="panel-body blood2" hidden>
						<label>
							4.4.5. Will blood collection occur less frequently than 2 times per week?
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="bloodFreq" value="1">Yes.
							</label>					
							<label class="radio-inline">
								<input type="radio" name="bloodFreq" value="0">No.
							</label>
						</div>
					</div>
				</div>				
				<label class="radio-inline">
					<input type="radio" name="blood" class="expand" data-expand="no" value="0">No.
				</label>
			</div>					
		</div>	
	</div>
	<div class="panel panel-default"> <!-- biological specimens -->
		<div class="panel-body">		
			<label>
				4.5. Does your study involve the collection of biological specimens other than blood? (e.g, saliva, sweat, skin swab)?
			</label>
			<div>
				<label class="radio-inline">
					<input type="radio" class="expand" name="specimens" data-expand="yes" value="1">Yes.
				</label>									
				<label class="radio-inline">
					<input type="radio" class="expand" name="specimens" data-expand="no" value="0">No.
				</label>
			</div>
			<div class="panel panel-default specimens" id="specimens1" hidden>					
				<div class="panel-body">								
					<label>
						4.5.1. Please describe your collection procedure below. To qualify for expedited review and thus avoid a 2-3 week delay for full IRB review, your procedure must conform to the following description:
						<div class="panel-body">
							<p>Prospective collection of biological specimens for research purposes by noninvasive means. Examples: (a) hair and nail clippings in a nondisfiguring manner; (b) deciduous teeth at time of exfoliation or if routine patient care indicates a need for extraction; (c) permanent teeth if routine patient care indicates a need for extraction; (d) excreta and external secretions (including sweat); (e) uncannulated saliva collected either in an unstimulated fashion or stimulated by chewing gumbase or wax or by applying a dilute citric solution to the tongue; (f) placenta removed at delivery; (g) amniotic fluid obtained at the time of rupture of the membrane prior to or during labor; (h) supra- and subgingival dental plaque and calculus, provided the collection procedure is not more invasive than routine prophylactic scaling of the teeth and the process is accomplished in accordance with accepted prophylactic techniques; (i) mucosal and skin cells collected by buccal scraping or swab, skin swab, or mouth washings; (j) sputum collected after saline mist nebulization.</p>
							<p>(from Category 3 in <a href="http://www.hhs.gov/ohrp/policy/expedited98.html" target="_blank">http://www.hhs.gov/ohrp/policy/expedited98.html</a>)</p>								
						</div>
					</label>
					<textarea name="specimensExp" class="form-control countable" rows="5"></textarea>
				</div>
			</div>
		</div>		
	</div>	
</div>