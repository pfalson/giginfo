<validator name="validation">			
	<!-- Name Field -->
<div class="form-group col-sm-6">
    <label for="name">Name:</label>
    <input type="text" class="form-control" v-model="row.name" v-validate:name="{ $VALIDATION_RULES$ }" data-type="text" />
    <div v-if="$validation.name.invalid" class="alert alert-danger" role="alert">
	$VALIDATION_MESSAGES$	
	</div>
</div>	

<!-- Country Id Field -->
<div class="form-group col-sm-6">
    <label for="country_id">Country Id:</label>
    <input type="number" class="form-control" v-model="row.country_id" v-validate:country_id="{ $VALIDATION_RULES$ }" data-type="text" />
    <div v-if="$validation.country_id.invalid" class="alert alert-danger" role="alert">
	$VALIDATION_MESSAGES$	
	</div>
</div>	

<!-- Abbr Field -->
<div class="form-group col-sm-6">
    <label for="abbr">Abbr:</label>
    <input type="text" class="form-control" v-model="row.abbr" v-validate:abbr="{ $VALIDATION_RULES$ }" data-type="text" />
    <div v-if="$validation.abbr.invalid" class="alert alert-danger" role="alert">
	$VALIDATION_MESSAGES$	
	</div>
</div>				
</validator>	
