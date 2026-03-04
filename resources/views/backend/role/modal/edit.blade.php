<!-- Modifier Role Modal -->
<div class="modal fade" id="ModifierRole" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="role-title mb-2">Modifier Rôle</h3>
                    <p class="text-muted">Set role permissions</p>
                </div>
                <!-- Add role form -->
                <form id="roleFormEdit" class="row g-3" action="{{ route('update.roles') }}" method="POST">
                    @csrf

                    {{--Champs pour envoyer l'Id --}}
                    <input type="hidden" id="idRole" name="role_id" >

                    <div class="col-12 mb-4">
                        <label class="form-label" for="nameRoleEdit">Nom du rôle</label>
                        <input type="text" id="nameRoleEdit" name="name" class="form-control" placeholder="Entrer un nom de rôle" tabindex="-1" />
                    </div>
                    <div class="col-12">
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing" id="permission-tableEdit">
                                <thead>
                                <tr>
                                    <th class="text-nowrap fw-medium">
                                        Administrator Access
                                        <i class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows full access to the system"></i>
                                    </th>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAllEdit" />
                                            <label class="form-check-label" for="selectAllEdit"> Select All </label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ $permission->description }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                           id="permission_edit_id_{{ $permission->id }}"
                                                           name="permissions_edit[]"
                                                           value="{{ $permission->name }}" />
                                                    <label class="form-check-label" for="permission_edit_id_{{ $permission->id }}"> Autoriser </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--/ Permission table -->
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Modifier</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Modifier Role Modal -->
